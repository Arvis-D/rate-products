import Validator from './Validator';

export default class Length implements Validator {

  constructor(
    private name: string,
    private min: number,
    private max: number = Number.MAX_SAFE_INTEGER
  ) { }

  public getErrorMessage() {
    if (this.max === Number.MAX_SAFE_INTEGER) {
      return `${this.name} has to be at least ${this.min} characters long!`
    }

    return `${this.name} has to be between ${this.min} and ${this.max} characters long!`
  }

  public validate(val: string) {
    return (val.length >= this.min && val.length <= this.max);
  }
}