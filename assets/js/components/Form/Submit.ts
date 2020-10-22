import Subscriber from '../../helpers/Subscriber/Subscriber';
import FormValid from './Event/FormValid';
import FormInvalid from './Event/FormInvalid';

export default class Submit implements Subscriber {
  public subscribedEvents = {
    [FormValid.name]: this.unsetDisabled.bind(this),
    [FormInvalid.name]: this.setDisabled.bind(this)
  }

  constructor (
    public dom: HTMLButtonElement
  ) { }

  public setDisabled() {
    this.dom.disabled = true;
  }

  public unsetDisabled() {
    this.dom.disabled = false;
  }
}