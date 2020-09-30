import Subscriber from '../../../helpers/Subscriber/Subscriber';
import PictureChosen from '../Event/PictureChosen';

export default class PreUploadPic implements Subscriber{
  public subscribedEvents = {
    [PictureChosen.name]: this.onPictureChosen.bind(this)
  }

  constructor(private dom: HTMLElement) { }

  public onPictureChosen(event: PictureChosen) {
    this.showPicture(event.url);
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