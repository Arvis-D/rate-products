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
    return (this.repeat.input.value === val);
  }
}