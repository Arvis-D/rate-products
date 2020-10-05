import Validator from './Validator';

export default class Email implements Validator {
  public getErrorMessage() {
    return 'Email has to be valid!';
  }

  public validate(value: string) {
    return /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(value);
  }
}