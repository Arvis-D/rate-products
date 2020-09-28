import Subscriber from '../../../helpers/Subscriber/Subscriber';
import { pictureEvents } from '../Event/events';
import PictureEvent from '../Event/PictureEvent';
import Request from '../../../helpers/Request';
import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import { likeEvents } from '../../LikeControls/events';
import LikeEvent from '../../LikeControls/LikeEvent';
import { toggleSpinner } from '../../../helpers/spinner';

export default class ChangeablePicture implements Subscriber {
  public subscribedEvents = [pictureEvents.selected];
  public picture: HTMLElement;

  constructor(
    private dom: HTMLElement,
    private fetchUrl: string,
    private dispatcher: Dispatcher
  ) { }

  public async changePicture(id: number) {
    toggleSpinner(this.dom);
    let data = await this.fetchPicture(id);
    console.log(data);
    if (data) {
      let cssUrl = `url('${data.url}')`;
      this.dom.style.backgroundImage = cssUrl;
      this.dom.setAttribute('href', data.url);

      let pictureEvent: PictureEvent = {
        name: pictureEvents.fetched,
        addedBy: data.username,
        timeElapsed: data.elapsed
      };
  
      let likeEvent: LikeEvent = {
        name: likeEvents.infoRecieved,
        likes: data.likes,
        dislikes: data.dislikes,
        id: data.id
      }
  
      this.dispatcher.dispatch(likeEvent);
      this.dispatcher.dispatch(pictureEvent);
    }

    toggleSpinner(this.dom);
  }

  private fetchPicture(id: number) {
    return new Request()
      .methodGet()
      .setUrl(this.fetchUrl + `/${id}`)
      .send()
      .then(res => (res.ok ? res.json() : null))
      .catch(error => console.log(error));
  }

  public actOnEvent(event: PictureEvent) {
    //if (this.dom.style.backgroundImage.split("'")[1] !== event.url) {
      this.changePicture(event.id);
    //}
  }
}