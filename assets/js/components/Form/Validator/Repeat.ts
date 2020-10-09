import Validator from './Validator';
import Input from '../Input';

export default class Repeat implements Validator{
  constructor (
    private repeat: Input,
    private name: string
  ) { }

  public getErrorMessage() {
    return `${this.name} does not match!`;
  }

  public validate(val: string) {
    let repeat = this.repeat.input.value;

    if (this.repeat.optional && repeat === '') {
      return true;
    }

    return (repeat !== '' && repeat === val);
  }
}