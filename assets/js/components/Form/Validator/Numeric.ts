import Validator from './Validator';

export default class Numeric implements Validator{
  constructor(
    private name: string
  ) { }

  public getErrorMessage() {
    return `${this.name} has to be a number!`;
  }

  public validate(val: string) {
    return (!isNaN(val as any) || val === '');
  }
}