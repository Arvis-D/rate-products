import Dispatcher from '../../helpers/Subscriber/Dispatcher';
import Validator from './Validator/Validator';
import ErrorFound from './Event/ErrorFound';
import RequirementPassed from './Event/RequirementsPassed';
import { spinnerType, SpinnerOverlay } from '../../helpers/spinner';

export default class Input {
  /**
   * Order of validators should be considered.
   * If one requirement fails, others wont be tested further
   */

  private validators: Array<Validator> = [];
  private asyncValidators: Array<Validator> = [];
  public valid: boolean = false;
  private error: HTMLElement = null;
  public input: HTMLInputElement;
  private spinner: SpinnerOverlay;
  public displayErrors: boolean = false;

  constructor (
    /**
     * Should contain input
     */

    private dom: HTMLElement,
    private dispatcher: Dispatcher,
    private optional: boolean = false
  ) {
    this.input = this.dom.querySelector('input');
    this.input.addEventListener('input', () => {this.validate()});
    this.input.addEventListener('input', () => {this.validateAsync()})

    this.spinner = new SpinnerOverlay(this.input, spinnerType.small);
  } 

  public addValidators(validators: Array<Validator>) {
    this.validators = [...validators, ...this.validators];
  }

  public addAsyncValidator(validators: Array<Validator>) {
    this.asyncValidators = [...validators, ...this.asyncValidators];
  }

  public async validateAsync() {
    if (this.checkOptional()) {
      return;
    }

    if (!this.valid) {
      return;
    }

    const {asyncValidators} = this;
    this.spinner.add();

    for (let i = 0; i < asyncValidators.length; i++) {
      let valid = await asyncValidators[i].validate(this.input.value);
      if (!valid) {
        this.invalid(asyncValidators[i].getErrorMessage())

        this.spinner.remove();
        return;
      }
    }

    this.spinner.remove();
    this.isValid()
  }

  public validate() {
    if (this.checkOptional()) {
      return;
    }

    const {validators} = this;

    for (let i = 0; i < validators.length; i++) {
      if (!validators[i].validate(this.input.value)) {
        this.invalid(validators[i].getErrorMessage())

        return false;
      }
    }

    this.isValid()

    return true;
  }

  private displayError(msg: string) {
    if (!this.error && this.displayErrors) {
      this.dom.classList.add('error');
      let error = document.createElement('div');
      error.classList.add('mb-3');
      error.innerHTML = `<strong class="text-danger">${msg}</strong>`;
      this.error = error;
      this.dom.parentNode.insertBefore(error, this.dom.nextSibling);
    }
  }

  private invalid(msg: string = null) {
    this.valid = false;
    this.displayError(msg);
    this.dispatcher.dispatch(new ErrorFound);
  }

  private isValid() {
    this.valid = true;
    this.dispatcher.dispatch(new RequirementPassed);

    if (this.error) {
      this.dom.classList.remove('error');
      this.error.remove();
      this.error = null;
    }
  }

  private checkOptional() {
    if (this.optional && this.input.value === '') {
      this.isValid();

      return true;
    }

    return false;
  }
}