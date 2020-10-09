import Input from './Input';
import Subscriber from '../../helpers/Subscriber/Subscriber';
import ErrorFound from './Event/ErrorFound';
import RequirementPassed from './Event/RequirementsPassed';
import Dispatcher from '../../helpers/Subscriber/Dispatcher';
import FormInvalid from './Event/FormInvalid';
import FormValid from './Event/FormValid';

export default class Form implements Subscriber {
  private inputs: Array<Input> = [];
  private valid: boolean = false;

  constructor (
    private dispatcher: Dispatcher
  ) { }

  public subscribedEvents = {
    [RequirementPassed.name]: this.checkIfAllValid.bind(this),
    [ErrorFound.name]: this.checkIfAllValid.bind(this)
  }

  public add(input: Array<Input>) {
    this.inputs = [...input, ...this.inputs] as Array<Input>;
  }

  public checkIfAllValid() {
    for (let i = 0; i < this.inputs.length; i++) {
      if (!this.inputs[i].valid) {
        this.dispatcher.dispatch(new FormInvalid);

        return;
      }
    }

    this.dispatcher.dispatch(new FormValid);
  }

  public init() {
    this.inputs.forEach(i => {
      i.dispatch = false;
      i.displayErrors = false;
      i.validate();
      i.validateAsync()
      i.displayErrors = true;
      i.dispatch = true;
    })

    console.log(this.inputs);
  }
}