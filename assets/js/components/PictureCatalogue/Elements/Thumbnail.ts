import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import PictureEvent from '../Event/PictureEvent';
import { pictureEvents } from '../Event/events';

export default class Thumbnail {
  private id: number;

  constructor(
    private dom: HTMLElement,
    private dispatcher: Dispatcher
  ) {
    this.id = parseInt(this.dom.querySelector('input').value);
    this.dom.addEventListener('click', () => {this.choosePicture()});
  }
  
  private choosePicture() {
    let event: PictureEvent = {
      name: pictureEvents.selected, 
      id: this.id,
      url: this.dom.style.backgroundImage.split("'")[1]
    };
    
    this.dispatcher.dispatch(event);
  }
}