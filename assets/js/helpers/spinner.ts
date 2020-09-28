export enum spinnerType {
  small = 'spinner-small',
  default = 'spinner'
}

export function toggleSpinner(el: HTMLElement, spinnerClass: spinnerType = spinnerType.default) {
  if (el.classList.contains(spinnerClass)) {
    //el.style.removeProperty('opacity');
    el.style.removeProperty('width');
  } else {
    //el.style.opacity = '0';
  }

  el.classList.toggle(spinnerClass);
}