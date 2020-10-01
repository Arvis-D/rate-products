import Subscriber from '../../../helpers/Subscriber/Subscriber';
import PictureChosen from '../Event/PictureChosen';
import PictureChoiceCancelled from '../Event/PictureChoiceCanceled';

export default class PreUploadPic implements Subscriber{
  public subscribedEvents = {
    [PictureChosen.name]: this.onPictureChosen.bind(this),
    [PictureChoiceCancelled.name]: this.onPictureChoiceCancel.bind(this)
  }

  constructor(private dom: HTMLElement) { }

  public onPictureChosen(event: PictureChosen) {
    this.showPicture(event.url);
  }

  public onPictureChoiceCancel() {
    this.dom.style.backgroundImage = `url('/img/img.png')`;
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