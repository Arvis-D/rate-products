import Subscriber from '../../../helpers/Subscriber/Subscriber';
import Request from '../../../helpers/Request';
import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import { toggleSpinner } from '../../../helpers/spinner';
import Event from '../../../helpers/Subscriber/Event';
import PictureSelected from '../Event/PictureSelected';
import CurrentPictureDeleted from '../Event/CurrentPictureDeleted';
import PictureHidden from '../Event/PictureHidden';
import LikeInfoRecieved from '../../LikeControls/Event/LikeInfoRecieved';
import PictureFetched from '../Event/PictureFetched';

export default class ChangeablePicture implements Subscriber {
  public subscribedEvents = {
    [PictureSelected.name]: this.onPictureSelected.bind(this)
  };
  public picture: HTMLElement;
  private currentId: number = null;

  /**
   * used to dispatch events just for its children
   */

  public readonly localDispatcher: Dispatcher;

  constructor(
    private dom: HTMLElement,
    private fetchUrl: string,
    private dispatcher: Dispatcher
  ) {
    this.localDispatcher = new Dispatcher();
  }

  public async changePicture(id: number) {
    toggleSpinner(this.dom);
    let data = await this.fetchPicture(id);
    //console.log('changePicture', data)
    if (data) {
      this.currentId = id;
      this.successfulFetch(data);
    }

    toggleSpinner(this.dom);
  }
  
  private showPicture(url: string) {
    let cssUrl = `url('${url}')`;
    this.dom.style.backgroundImage = cssUrl;
    this.dom.setAttribute('href', url);
  }

  public onPictureSelected(ev: PictureSelected) {
    this.changePicture(ev.id);
  }

  private successfulFetch(data: any) {
    this.showPicture(data.url);

    this.dispatcher.dispatch(new PictureFetched(
      data.username,
      data.elapsed
    ))

    this.dispatcher.dispatch(new LikeInfoRecieved(
      data.likes,
      data.dislikes,
      data.id,
      (data.userLike ? data.userLike.like : null)
    ));
  }

  private fetchPicture(id: number) {
    console.log('fetchPicture' ,this.fetchUrl + `/${id}`)
    return new Request()
      .methodGet()
      .setUrl(this.fetchUrl + `/${id}`)
      .send()
      .then(res => (res.ok ? res.json() : null))
      .catch(error => console.log(error));
  }

  private noPicture() {
    this.showPicture('/img/blank.jpg');
    this.dom.classList.add('.no-image');
    this.dispatcher.dispatch(new PictureHidden);
  }

  private checkIfDeletedCurrent(id: number) {
    if (this.currentId === id) {
      this.noPicture();
      this.dispatcher.dispatch(new CurrentPictureDeleted());
    }
  }
}