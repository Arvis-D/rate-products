import Subscriber from '../../../helpers/Subscriber/Subscriber';
import PictureFetched from '../Event/PictureFetched';
import LastPictureRemoved from '../Event/LastPictureRemoved';
import FirstPictureAdded from '../Event/FirstPictureAdded';
import CurrentPictureDeleted from '../Event/CurrentPictureDeleted';

export default class PictureInfo implements Subscriber{
  private username: HTMLElement;
  private timeElapsed: HTMLElement;

  public subscribedEvents = {
    [PictureFetched.name]: this.onPictureFetch.bind(this),
    [LastPictureRemoved.name]: this.onLastPicture.bind(this),
    [FirstPictureAdded.name]: this.onFirstPicture.bind(this),
    [CurrentPictureDeleted.name]: this.onCurrentPictureDelete.bind(this)
  }

  public onPictureFetch(event: PictureFetched) {
    this.setTimeElapsed(event.elapsed);
    this.setUsername(event.addedBy);
  }

  public onLastPicture() {

  }

  public onFirstPicture() {

  }

  public onCurrentPictureDelete() {

  }

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
}