import Validator from './Validator';

export default class NumericSize implements Validator{
  constructor(
    private name: string,
    private min: number,
    private max: number
  ) { }

  public getErrorMessage() {
    if (this.max === Number.MAX_SAFE_INTEGER) {
      return `${this.name} has to be at least ${this.min}!`
    }

    return `${this.name} has to be between ${this.min} and ${this.max}!`
  }

  public validate(val: string) {
    let num = Number(val);

    return (num >= this.min && num <= this.max);
  }
}