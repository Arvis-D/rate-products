import {ajaxForm} from '../../helpers/ajaxForm';
import ImageFormDom from './Dom/ImageFormDom';
import Dispatcher from '../../helpers/Subscriber/Dispatcher';
import PictureEvent from './Event/PictureEvent';
import { toggleSpinner } from '../../helpers/spinner';

export default class ImageForm {
  private preUploadUrl: string;

  constructor (private dom: ImageFormDom) {
    this.addEventListeners();
  }

  private showPicturePreUpload() {
    let url = URL.createObjectURL(this.dom.imageInput.files[0]);
    try {
      this.dom.inputShowcase.style.backgroundImage = `url('${url}')`;
    } catch (error) { }

    this.preUploadUrl = url;

    this.dom.inputShowcase.onload = () => {
      URL.revokeObjectURL(url)
    }
  }

  private async handleUploadClick() {
    toggleSpinner(this.dom.base, 'spinner-small');
    this.dom.base.innerHTML = '';
    let res = await ajaxForm(this.dom.imageUploadForm).then(res => res.text());
    console.log(res);
    this.dom.base.innerHTML = res;
    toggleSpinner(this.dom.base, 'spinner-small');
    this.dom.update();
    this.dom.inputShowcase.style.backgroundImage = `url('${this.preUploadUrl}')`;

    const event: PictureEvent = {name: 'pictureAdded', pictureUrl: this.preUploadUrl};
    Dispatcher.dispatch(event);
  }

  private addEventListeners() {
    this.dom.imageInput.addEventListener('change', () => {this.showPicturePreUpload()});
    this.dom.uploadBtn.addEventListener('click', () => {this.handleUploadClick()});
  }
}