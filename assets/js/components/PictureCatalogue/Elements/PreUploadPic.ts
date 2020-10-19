import Subscriber from '../../../helpers/Subscriber/Subscriber';
import PictureChosen from '../Event/PictureChosen';
import PictureChoiceCancelled from '../Event/PictureChoiceCanceled';

export default class PreUploadPic implements Subscriber{
  private img: HTMLImageElement;
  public subscribedEvents = {
    [PictureChosen.name]: this.onPictureChosen.bind(this),
    [PictureChoiceCancelled.name]: this.onPictureChoiceCancel.bind(this)
  }

  constructor(private dom: HTMLElement) {
    this.img = this.dom.firstElementChild as HTMLImageElement;
    console.log(this.img)
  }

  public onPictureChosen(event: PictureChosen) {
    this.showPicture(event.url);
  }

  public onPictureChoiceCancel() {
    this.img.setAttribute('src', '/img/img.png');
  }

  private showPicture(url: string) {
    console.log(this.img, url);
    this.img.setAttribute('src', url);

    try {
    } catch (error) { }

    this.dom.onload = () => {
      URL.revokeObjectURL(url)
    }
  }
}