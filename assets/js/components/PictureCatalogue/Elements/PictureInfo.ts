import Subscriber from '../../../helpers/Subscriber/Subscriber';
import PictureEvent from '../Event/PictureEvent';
import { pictureEvents } from '../Event/events';

export default class PictureInfo implements Subscriber{
  private username: HTMLElement;
  private timeElapsed: HTMLElement;
  public subscribedEvents = [pictureEvents.fetched];

  constructor(
    private dom: HTMLElement
  ) {
    this.username = dom.children[0] as HTMLElement;
    this.timeElapsed = dom.children[1] as HTMLElement;
  }

  setUsername(name: string) {
    this.username.innerHTML = name;
  }

  setTimeElapsed(name: string) {
    this.timeElapsed.innerHTML = name;
  }

  actOnEvent(event: PictureEvent) {
    console.log(event);
    this.setTimeElapsed(event.timeElapsed);
    this.setUsername(event.addedBy);
  }
}