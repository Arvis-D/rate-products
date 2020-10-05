import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import Subscriber from '../../../helpers/Subscriber/Subscriber';
import PictureDeleted from '../Event/PictureDeleted';
import PictureChosen from '../Event/PictureChosen';
import PictureUploaded from '../Event/PictureUploaded';
import PictureChoiceCancelled from '../Event/PictureChoiceCanceled';

export default class ImageInput implements Subscriber{
  public subscribedEvents = {
    [PictureDeleted.name]: this.onPictureDelete.bind(this),
    [PictureUploaded.name]: this.onPictureUpload.bind(this)
  }

  constructor (
    private dom: HTMLInputElement,
    private dispatcher: Dispatcher
  ) {
    this.dom.addEventListener('change', () => {this.chooseImage()});
  }

  public onPictureDelete() {
    this.chooseImage();
    this.display();
  }

  public onPictureUpload() {
    this.hide();
  }

  private chooseImage() {
    console.log(this.dom.value)
    try {
      let url = URL.createObjectURL(this.dom.files[0]);
      this.dispatcher.dispatch(new PictureChosen(url));
    } catch(e) {
      this.dispatcher.dispatch(new PictureChoiceCancelled);
    }
  }

  public display() {
    this.dom.classList.remove('d-none');
  }

  public hide() {
    this.dom.classList.add('d-none');
  }
}