export enum spinnerType {
  small = 'spinner-small',
  default = 'spinner'
}

export function toggleSpinner(el: HTMLElement, spinnerClass: spinnerType = spinnerType.default) {
  el.classList.toggle(spinnerClass);
}

export class SpinnerOverlay {
  private spinner: HTMLElement;

  constructor (
    /**
     * element on top of which spinner will sit
     */
    
    private base: HTMLElement,
    private spinnerClass: spinnerType = spinnerType.default
  ) { }

  public add() {
    let rect = this.base.getBoundingClientRect();
    let spin = document.createElement('div')
    spin.style.position = 'absolute';
    spin.style.zIndex = (10000).toString();
    spin.classList.add(this.spinnerClass);
    spin.style.width = rect.width + 'px';
    spin.style.height = rect.height + 'px';
    spin.style.left = rect.x + 'px';
    spin.style.top = rect.y + 'px';
    document.body.appendChild(spin);

    this.spinner = spin;
  }

  public remove() {
    this.spinner.remove();
  }
}