import SubmitStrategy from './SubmitStrategy';
import Request from '../../../helpers/Request';

export default class AddImage implements SubmitStrategy{
  constructor (private form: HTMLFormElement) { }

  public submit() {
    return Request.create()
      .form(this.form)
      .send();
  }
}