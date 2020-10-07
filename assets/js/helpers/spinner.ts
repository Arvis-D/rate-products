export enum spinnerType {
  small = 'spinner-small',
  default = 'spinner'
}

export function toggleSpinner(el: HTMLElement, spinnerClass: spinnerType = spinnerType.default) {
  el.classList.toggle(spinnerClass);
}

export class SpinnerOverlay {
  private spinner: HTMLElement = null;
  private rect: DOMRect = null;

  constructor (
    /**
     * element on top of which spinner will sit
     */
    
    private base: HTMLElement,
    private spinnerClass: spinnerType = spinnerType.default
  ) { }

  public add() {
    if (this.spinner === null) {
      this.rect = this.base.getBoundingClientRect();
      this.spinner = document.createElement('div');
      this.addStyles();
      document.body.appendChild(this.spinner);
    }
  }

  private addStyles() {
    let {spinner: spin, rect} = this;

    spin.style.position = 'absolute';
    spin.style.zIndex = (10000).toString();
    spin.classList.add(this.spinnerClass);
    spin.style.width = rect.width + 'px';
    spin.style.height = rect.height + 'px';
    spin.style.left = rect.x + 'px';
    spin.style.top = rect.y + 'px';
  }

  public remove() {
    if (this.spinner !== null) {
      this.spinner.remove();
      this.spinner = null;
    }
  }
}