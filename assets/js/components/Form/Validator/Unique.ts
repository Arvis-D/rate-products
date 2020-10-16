import Validator from './Validator';
import Ajax from '../../../helpers/Ajax';

export default class Unique implements Validator{
  private memory: {[val: string]: boolean} = {};
  private inRequest: boolean = false;
  private doNotCheck: string = null;

  constructor(
    private name: string,

    /**
     * @param spinner where spinner will appear
     */

     private spinner: HTMLElement,
     private resource: string,
     private resourceField: string
  ) { }

  public getErrorMessage() {
    return `${this.name} is already taken!`;
  }

  public async validate(val: string) {
    if (val === '' || (this.doNotCheck !== null && val === this.doNotCheck)) {
      return true;
    }

    if (val in this.memory) {
      return this.memory[val];
    }

    this.memory[val] = await this.checkUnique(val);

    return this.memory[val];
  }

  public setdoNotCheck(doNotCheck: string) {
    this.doNotCheck = doNotCheck;

    return this;
  }

  public checkUnique(val: string) {
    return Ajax.create()
    .setUrl(`/api/unique/${this.resource}/${this.resourceField}/${val}`)
    .methodGet()
    .send()
    .then(res => (res.status === 200 ? res.json() : null))
    .then(res => (res === null ? null : res.unique))
    .catch(err => null);
  }

  public static create(name: string, spinner: HTMLElement, resource: string, field: string) {
    return new Unique(name, spinner, resource, field);
  }
}