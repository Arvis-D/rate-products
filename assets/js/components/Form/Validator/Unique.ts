import Validator from './Validator';
import Request from '../../../helpers/Request';

export default class Unique implements Validator{
  private memory: {[val: string]: boolean} = {};
  private inRequest: boolean = false;

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
    if (val === '') {
      return true;
    }

    if (val in this.memory) {
      return this.memory[val];
    }

    this.memory[val] = await this.checkUnique(val);

    return this.memory[val];
  }


  public checkUnique(val: string) {
    return Request.create()
    .setUrl(`/api/unique/${this.resource}/${this.resourceField}/${val}`)
    .methodGet()
    .send()
    .then(res => (res.status === 200 ? res.json() : null))
    .then(res => (res === null ? null : res.unique))
    .catch(err => null);
  }
}