import Thumbnail from './Thumbnail';
import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import Subscriber from '../../../helpers/Subscriber/Subscriber';
import PictureEvent from '../Event/PictureEvent';
import { pictureEvents } from '../Event/events';

export default class PictureSelector implements Subscriber{
  private thumbnails: Array<Thumbnail> = [];
  public subscribedEvents = [pictureEvents.deleted, pictureEvents.uploaded];

  constructor (
    private dom: HTMLElement,
    private dispatcher: Dispatcher
  ) {
    this.dom.querySelectorAll('.selector-thumbnail').forEach(e => {
      let thumbnail = new Thumbnail(e as HTMLElement, this.dispatcher);
      this.thumbnails.push(thumbnail);
    });
  }

  public actOnEvent(event: PictureEvent) {
    
  }
}