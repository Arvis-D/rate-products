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
    [PictureDeleted.name]: this.onLastPicture.bind(this),
    [PictureUploaded.name]: this.onFirstPicture.bind(this),
    [CurrentPictureDeleted.name]: this.onCurrentPictureDelete.bind(this)
  }

  constructor (
    private dom: HTMLElement,
    private dispatcher: Dispatcher
  ) {
    this.dom.querySelectorAll('.selector-thumbnail').forEach(e => {
      this.addThumbnail(e as HTMLElement);
    });
  }

  public onCurrentPictureDelete() {

  }

  public onFirstPicture() {

  }

  public onLastPicture() {

  }

  private getLastId() {
    return (this.thumbnails.length === 0 ? null : this.thumbnails[this.thumbnails.length - 1].id);
  }

  private addThumbnail(el: HTMLElement) {
    let thumbnail = new Thumbnail(el as HTMLElement, this.dispatcher);
    this.thumbnails.push(thumbnail);
  }

  private addPicture(id: number, url: string) {
    this.check(false);
    let thumb = Thumbnail.createDom(id, url);
    this.dom.appendChild(thumb)
    this.addThumbnail(thumb);
  }

  private removeThumbnail(id: number) {
    this.thumbnails = this.thumbnails.filter(e => {
      if (e.id === id) {
        this.dom.removeChild(e.dom);
      } else {
        return e;
      }
    });

    if (!this.check(true)) {
      this.dispatcher.dispatch(new ThumbnailRemoved(
        id,
        this.getLastId()
      ));
    }
  }

  private check(last: boolean = true) {
    if (this.thumbnails.length === 0) {
      if (last) {
        this.dispatcher.dispatch(new LastPictureRemoved);
      } else {
        this.dispatcher.dispatch(new FirstPictureAdded)
      }
      return false;
    } else {

      return true;
    }
  }
}