import PictureSelectorDom from './Dom/PictureSelectorDom';
import Dispatcher from '../../helpers/Subscriber/Dispatcher';
import PictureEvent from './Event/PictureEvent';

export default class PictureSelector {
  constructor (public dom: PictureSelectorDom) {
    this.dom.thumbnails.forEach(e => {
      e.addEventListener('click', (ev) => {this.choosPicture(ev)})
    });
  }

  private choosPicture(ev: Event) {
    let thumbnail = ev.target as HTMLElement
    let cssUrl = thumbnail.style.backgroundImage.split(`"`)[1];
    const event: PictureEvent = {name: 'pictureSelected', pictureUrl: cssUrl};
    Dispatcher.dispatch(event);
  }
}