import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import PictureEvent from '../Event/PictureEvent';
import { pictureEvents } from '../Event/events';
import Subscriber from '../../../helpers/Subscriber/Subscriber';

export default class ImageInput implements Subscriber{
  public subscribedEvents = [pictureEvents.uploaded, pictureEvents.deleted];

  constructor (
    private dom: HTMLInputElement,
    private dispatcher: Dispatcher
  ) {
    this.dom.addEventListener('change', () => {this.chooseImage()});
  }

  public actOnEvent(event: PictureEvent) {

  }

  private chooseImage() {
    let url = URL.createObjectURL(this.dom.files[0]);
    this.dispatcher.dispatch({name: pictureEvents.chosen, url: url} as PictureEvent);
  }

  public display() {
    this.dom.style.removeProperty('display');
  }

  public hide() {
    this.dom.style.display = 'none';
  }
}