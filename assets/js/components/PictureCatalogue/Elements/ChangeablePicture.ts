import Subscriber from '../../../helpers/Subscriber/Subscriber';
import Ajax from '../../../helpers/Ajax';
import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import { toggleSpinner } from '../../../helpers/spinner';
import PictureSelected from '../Event/PictureSelected';
import LikeInfoRecieved from '../../LikeControls/Event/LikeInfoRecieved';
import PictureFetched from '../Event/PictureFetched';
import ParentHidden from '../../Events/ParentHidden';
import ThumbnailRemoved from '../Event/ThumbnailRemoved';
import FirstPictureAdded from '../Event/FirstPictureAdded';
import LastPictureRemoved from '../Event/LastPictureRemoved';
import ParentShown from '../../Events/ParentShown';

export default class ChangeablePicture implements Subscriber {
  public subscribedEvents = {
    [PictureSelected.name]: this.onPictureSelected.bind(this),
    [ThumbnailRemoved.name]: this.onThumbnailRemove.bind(this),
    [FirstPictureAdded.name]: this.onFirstPicture.bind(this),
    [LastPictureRemoved.name]: this.onLastPicture.bind(this)
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

  public onThumbnailRemove(event: ThumbnailRemoved) {
    if (this.checkIfRemovedCurrent(event.removedId)) {
      this.changePicture(event.newLastId);
    }
  }

  public onLastPicture() {
    this.noPicture();
  }

  public onFirstPicture(event: FirstPictureAdded) {
    this.show();
    this.changePicture(event.pictureId);
  }

  private show() {
    this.dom.classList.remove('no-image');
    this.localDispatcher.dispatch(new ParentShown);
  }

  public async changePicture(id: number) {
    toggleSpinner(this.dom);
    let data = await this.fetchPicture(id);
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
    return new Ajax()
      .methodGet()
      .setUrl(this.fetchUrl + `/${id}`)
      .send()
      .then(res => (res.status === 200 ? res.json() : null))
      .catch(error => console.log(error));
  }

  private noPicture() {
    this.showPicture('/img/blank.jpg');
    this.dom.classList.add('no-image');
    this.localDispatcher.dispatch(new ParentHidden);
  }

  private checkIfRemovedCurrent(id: number) {
    if (this.currentId === id) {
      return true;
    }

    return false;
  }
}