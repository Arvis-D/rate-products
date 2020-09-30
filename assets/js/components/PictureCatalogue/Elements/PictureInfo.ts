import Subscriber from '../../../helpers/Subscriber/Subscriber';
import PictureFetched from '../Event/PictureFetched';
import LastPictureRemoved from '../Event/LastPictureRemoved';
import FirstPictureAdded from '../Event/FirstPictureAdded';
import CurrentPictureDeleted from '../Event/CurrentPictureDeleted';
import ParentShown from '../../Events/ParentShown';
import ParentHidden from '../../Events/ParentHidden';

export default class PictureInfo implements Subscriber{
  private username: HTMLElement;
  private timeElapsed: HTMLElement;

  public subscribedEvents = {
    [PictureFetched.name]: this.onPictureFetch.bind(this),
    [ParentShown.name]: this.onParentShow.bind(this),
    [ParentHidden.name]: this.onParentHide.bind(this)
  }

  public onPictureFetch(event: PictureFetched) {
    this.setTimeElapsed(event.elapsed);
    this.setUsername(event.addedBy);
  }

  public onParentHide() {
    this.dom.classList.add('d-none');
  }

  public onParentShow() {
    this.dom.classList.remove('d-none');
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