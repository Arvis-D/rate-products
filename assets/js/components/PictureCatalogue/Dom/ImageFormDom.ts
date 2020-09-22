import BaseDom from '../../../helpers/BaseDom';

export default class ImageFormDom extends BaseDom {
  public imageInput: HTMLInputElement;
  public inputShowcase: HTMLElement;
  public imageUploadForm: HTMLFormElement;
  public uploadBtn: HTMLElement;

  constructor (imageForm: HTMLElement) {
    super(imageForm);
  }

  public update() {
    this.imageInput = this.one('.image-input') as HTMLInputElement;
    this.inputShowcase = this.one('.upload-showcase');
    this.uploadBtn = this.one('.upload-btn');
    this.imageUploadForm = this.one('.image-upload-form') as HTMLFormElement;
  }
}