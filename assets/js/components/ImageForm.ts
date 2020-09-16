import {ajaxForm} from '../helpers/ajaxForm';

export default class ImageForm {
  private imageInput: HTMLInputElement;
  private inputShowcase: HTMLElement;
  private imageUploadForm: HTMLFormElement;
  private uploadBtn: HTMLElement;

  constructor (private imageUploadDom: HTMLElement) {
    this.setDom();
    this.addEventListeners();
  }

  private showPicturePreUpload() {
    let url = URL.createObjectURL(this.imageInput.files[0]);
    try {
      this.inputShowcase.style.backgroundImage = `url('${url}')`;
    } catch (error) { }

    this.inputShowcase.onload = () => {
      URL.revokeObjectURL(url)
    }
  }

  private async handleUploadClick() {
    let res = await ajaxForm(this.imageUploadForm);

    console.log(res.text());
  }

  private addEventListeners() {
    this.imageInput.addEventListener('change', () => {this.showPicturePreUpload()});
    this.uploadBtn.addEventListener('click', () => {this.handleUploadClick()});
  }

  private setDom() {
    this.imageInput = this.imageUploadDom.querySelector('.image-input');
    this.inputShowcase = this.imageUploadDom.querySelector('.upload-showcase');
    this.uploadBtn = this.imageUploadDom.querySelector('.upload-btn');
    this.imageUploadForm = this.imageUploadDom.querySelector('.image-upload-form');
  }
}