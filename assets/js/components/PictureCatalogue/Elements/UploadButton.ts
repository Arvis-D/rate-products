import { spinnerType, toggleSpinner } from '../../../helpers/spinner';
import SubmitStrategy from '.././SubmitStrategy/SubmitStrategy';

export default class UploadButton {
  private submitStrategy: SubmitStrategy;

  constructor(
    private dom: HTMLButtonElement,
    private url: string
  ) { }

  private async uploadImage() {
    toggleSpinner(this.dom, spinnerType.small);
    // if (res.id !== null) {
    //   this.input.hide();
    // }
  }

  private setSubmitStrategy(strategy: SubmitStrategy) {
    this.submitStrategy = strategy;
  }
}