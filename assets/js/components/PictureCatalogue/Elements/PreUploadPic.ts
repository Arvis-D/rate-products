import Subscriber from '../../../helpers/Subscriber/Subscriber';
import PictureEvent from '../Event/PictureEvent';
import { pictureEvents } from '../Event/events';

export default class PreUploadPic implements Subscriber{
  public subscribedEvents = [pictureEvents.chosen];

  constructor(private dom: HTMLElement) { }

  public actOnEvent(event: PictureEvent) {
    this.showPicture(event.url);
  }

  private showPicture(url: string) {
    try {
      this.dom.style.backgroundImage = `url('${url}')`;
    } catch (error) { }

    this.dom.onload = () => {
      URL.revokeObjectURL(url)
    }
  }
}