import ChangeablePicture from './Elements/ChangeablePicture';
import LikeControls from '../LikeControls/LikeControls';
import Dispatcher from '../../helpers/Subscriber/Dispatcher';
import PictureSelector from './Elements/PictureSelector';
import ImageInput from './Elements/ImageInput';
import UploadButton from './Elements/UploadButton';
import PreUploadPic from './Elements/PreUploadPic';
import PictureInfo from './Elements/PictureInfo';

export default class PictueCatalogue {
  public picture: ChangeablePicture;
  public like: LikeControls;
  public pictures: PictureSelector;
  public input: ImageInput;
  public upload: UploadButton;
  public preupload: PreUploadPic;
  public picInfo: PictureInfo;

  constructor(
    private subject: string, 
    private dom: HTMLElement,
    private dispatcher: Dispatcher
  ) {
    this.createElements();
  }

  private createElements() {
    this.createImageInput();
    this.createLikeAndInfo();
    this.createPicture();
    this.createUpload();
    this.createPreUpload();
    this.createSelector();
  }

  private createLikeAndInfo() {
    let dom = this.dom.querySelector('.like-controls') as HTMLElement;
    if (dom) {
      this.picInfo = new PictureInfo(this.dom.querySelector('.pic-info'));
      this.dispatcher.addSubscriber(this.picInfo);
      this.like = new LikeControls(
        `/api/${this.subject}/picture/like`,
        dom
      );
      this.dispatcher.addSubscriber(this.like);
    }
  }

  private createPicture() {
    this.picture = new ChangeablePicture(
      this.dom.querySelector('.picture'),
      `/api/${this.subject}/picture/show`,
      this.dispatcher
    );
    this.dispatcher.addSubscriber(this.picture);
  }

  private createUpload() {
    let dom = this.dom.querySelector('.upload-button') as HTMLButtonElement;
    if (dom) {
      this.upload = new UploadButton(
        dom,
        `api/${this.subject}/picture/store`
      )
    }
  }

  private createImageInput() {
    let dom = this.dom.querySelector('.image-input') as HTMLInputElement;
    if (dom) {
      this.input = new ImageInput(dom, this.dispatcher);
      this.dispatcher.addSubscriber(this.input);
    }
  }

  private createPreUpload() {
    let dom = this.dom.querySelector('.upload-showcase') as HTMLInputElement;
    if (dom) {
      this.preupload = new PreUploadPic(dom);
      this.dispatcher.addSubscriber(this.preupload);
    }
  }

  private createSelector() {
    let dom = this.dom.querySelector('.picture-selector') as HTMLElement;
    if (dom) {
      this.pictures = new PictureSelector(dom, this.dispatcher);
      this.dispatcher.addSubscriber(this.pictures);
    }
  }
}