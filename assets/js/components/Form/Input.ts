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
  public dispatch: boolean = false;

  constructor (
    /**
     * Should contain input
     */

    private dom: HTMLElement,
    private dispatcher: Dispatcher,
    public optional: boolean = false,
    public displayErrorMessages: boolean = true
  ) {
    this.input = this.dom.querySelector('input');
    this.input.addEventListener('input', () => {this.validate()});
    this.input.addEventListener('focusout', () => {this.validateAsync()})

    this.spinner = new SpinnerOverlay(this.input, spinnerType.small);
  } 

  public addValidators(validators: Array<Validator>) {
    this.validators = [...validators, ...this.validators];
  }

  public addAsyncValidator(validators: Array<Validator>) {
    this.asyncValidators = [...validators, ...this.asyncValidators];
  }

  public async validateAsync() {
    if (!this.valid || this.asyncValidators.length === 0 || this.checkOptional()) {
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
          this.invalid(validators[i].getErrorMessage());

        return false;
      }
    }

    this.isValid()

    return true;
  }

  private displayError(msg: string) {
    if (!this.error && this.displayErrors) {
      this.dom.classList.add('error');
      this.error = document.createElement('div');
      if (this.displayErrorMessages) {
        this.error.classList.add('mb-3');
        this.error.innerHTML = `<small class="text-danger">* ${msg}</small>`;
        this.dom.parentNode.insertBefore(this.error, this.dom.nextSibling);
      }
    }
  }

  private invalid(msg: string = null) {
    this.valid = false;
    if (this.dispatch) {
      this.dispatcher.dispatch(new ErrorFound)
    }

    this.displayError(msg);
  }

  private isValid() {
    this.valid = true;

    if (this.dispatch) {
      this.dispatcher.dispatch(new RequirementPassed)
    }
    
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