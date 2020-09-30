import { spinnerType, toggleSpinner } from '../../../helpers/spinner';
import csrf from '../../../helpers/Subscriber/csrf';
import Subscriber from '../../../helpers/Subscriber/Subscriber';
import Request from '../../../helpers/Request';
import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import PictureChosen from '../Event/PictureChosen';
import PictureUploaded from '../Event/PictureUploaded';
import PictureDeleted from '../Event/PictureDeleted';

export default class UploadButton implements Subscriber{
  public subscribedEvents = {
    [PictureChosen.name]: this.onPictureChosen.bind(this)
  }
  private imageChosen: boolean = false;
  private dispatcher: Dispatcher;
  private deletePicUrl: string;
  private tempUrl: string;

  constructor(
    private dom: HTMLButtonElement,
    private uploadForm: HTMLFormElement,
    private deleteUrl: string,
    private imageId?: number,
  ) {
    this.dom.addEventListener('click', () => {this.submit()});
  }

  public onPictureChosen(event: PictureChosen) {
    this.imageChosen = true;
    this.tempUrl = event.url;
  }

  public setDispatcher(dispatcher: Dispatcher) {
    this.dispatcher = dispatcher;
  }

  public setDeleteUrl(url: string) {
    this.deletePicUrl = url;
  }

  private async submit() {
    toggleSpinner(this.dom, spinnerType.small);
    if (this.imageId !== null) {
      if (await this.deleteImage()) {
        this.handleSucessfulDelete();
      }
    } else if(this.imageChosen){
      let id = await this.storeImage();
      this.imageId = id;
      if (id !== null) {
        this.handleSucessfulUpload();
      }
    }
    toggleSpinner(this.dom, spinnerType.small);
  }

  private deleteImage() {
    return Request.create()
      .add('picture-id', this.imageId.toString())
      .add('picture-url', this.deletePicUrl)
      .add('csrf', csrf())
      .setUrl(this.deleteUrl)
      .send()
      .then(res => res.ok);
  }

  private storeImage() {
    console.log('storeImage')
    return Request.create()
      .form(this.uploadForm)
      .send()
      .then(res => res.json())
      .then(res => res.id)
      .catch(err => null)
  }

  private handleSucessfulUpload() {
    this.toggleButton();
    // this.dispatcher.dispatch({
    //   name: pictureEvents.uploaded,
    //   id: this.imageId,
    //   url: this.tempUrl
    // } as PictureEvent)

    this.dispatcher.dispatch(new PictureUploaded(
      this.imageId
    ));
  }

  private handleSucessfulDelete() {
    this.imageChosen = false;
    this.dispatcher.dispatch(new PictureDeleted(
      this.imageId
    ));

    this.imageId = null;
    this.toggleButton();
  }

  private toggleButton() {;
    this.dom.classList.toggle('btn-primary');
    this.dom.innerHTML = (this.dom.classList.toggle('btn-danger') ? 'Delete' : 'Upload');
  }
}