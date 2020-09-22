import Dispatcher from '../../helpers/Subscriber/Dispatcher';
import PictureEvent from './Event/PictureEvent';
import Subscriber from '../../helpers/Subscriber/Subscriber';
import MainPictureDom from './Dom/ManPictureDom';

export default class MainPicture implements Subscriber{
  public readonly subscribedEvents: Array<string> = [
      'pictureSelected',
      'pictureAdded'
    ];

  constructor (public dom: MainPictureDom) {
    Dispatcher.addSubscriber(this);
  }

  public actOnEvent(event: PictureEvent) {
    const {picture} = this.dom;
    let largePicUrl = event.pictureUrl.replace('--icon', '--size');
    picture.style.backgroundImage = `url('${largePicUrl}')`;
    picture.setAttribute('href', largePicUrl);
  }
}