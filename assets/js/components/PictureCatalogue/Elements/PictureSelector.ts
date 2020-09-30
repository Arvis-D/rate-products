import Thumbnail from './Thumbnail';
import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import Subscriber from '../../../helpers/Subscriber/Subscriber';
import ThumbnailRemoved from '../Event/ThumbnailRemoved';
import CurrentPictureDeleted from '../Event/CurrentPictureDeleted';
import PictureUploaded from '../Event/PictureUploaded';
import PictureDeleted from '../Event/PictureDeleted';
import FirstPictureAdded from '../Event/FirstPictureAdded';
import LastPictureRemoved from '../Event/LastPictureRemoved';

export default class PictureSelector implements Subscriber{
  private thumbnails: Array<Thumbnail> = [];
  public subscribedEvents = {
    [PictureDeleted.name]: this.onPictureDeleted.bind(this),
    [PictureUploaded.name]: this.onPictureUploaded.bind(this)
  }

  constructor (
    private dom: HTMLElement,
    private dispatcher: Dispatcher
  ) {
    this.dom.querySelectorAll('.selector-thumbnail').forEach(e => {
      this.addPicture(e as HTMLElement);
    });
  }

  public onPictureUploaded(event: PictureUploaded) {
    this.addThumbnail(event.id, event.url)
  }

  public onPictureDeleted(event: PictureDeleted) {
    this.removeThumbnail(event.deletedId);
  }

  private getLastId() {
    return (this.thumbnails.length === 0 ? null : this.thumbnails[this.thumbnails.length - 1].id);
  }

  private addPicture(el: HTMLElement) {
    let thumbnail = new Thumbnail(el as HTMLElement, this.dispatcher);
    this.thumbnails.push(thumbnail);
  }

  private addThumbnail(id: number, url: string) {
    let thumb = Thumbnail.createDom(id, url);
    this.dom.appendChild(thumb)
    this.addPicture(thumb);
    this.checkIfFirst();
  }

  private removeThumbnail(id: number) {
    this.thumbnails = this.thumbnails.filter(e => {
      if (e.id === id) {
        this.dom.removeChild(e.dom);
      } else {
        return e;
      }
    });

    if (!this.checkIfLast()) {
      this.dispatcher.dispatch(new ThumbnailRemoved(
        id,
        this.getLastId()
      ));
    }
  }

  /**
   * checks if there are no thumbnails.
   * 
   * if there are no thumbnails and picture is being added or removed
   * appropriate event will fire
   * 
   * if thumnails are not empty it will just return false
   */

  private checkIfLast() {
    if (this.thumbnails.length === 0) {
        this.dispatcher.dispatch(new LastPictureRemoved);

      return true;
    } else {

      return false;
    }
  }

  private checkIfFirst() {
    if (this.thumbnails.length === 1) {
        this.dispatcher.dispatch(new FirstPictureAdded(this.getLastId()))

      return true;
    } else {

      return false;
    }
  }
}