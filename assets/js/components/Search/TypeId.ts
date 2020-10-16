import Subscriber from '../../helpers/Subscriber/Subscriber';
import EmptyResults from './Event/EmptyResults';
import TypeChosen from './Event/TypeChosen';

export default class TypeId implements Subscriber{
  constructor(
    private dom: HTMLInputElement
  ) {}

  public subscribedEvents = {
    [EmptyResults.name]: this.setEmpty.bind(this),
    [TypeChosen.name]: this.setId.bind(this)
  }

  public setEmpty() {
    this.dom.value = '';
  }

  public setId(res: TypeChosen) {
    this.dom.value = res.id.toString();
  }
}