export function toggleSpinner(el: HTMLElement, spinnerClass: string = 'spinner') {
  if (el.classList.contains(spinnerClass)) {
    el.style.removeProperty('height');
    el.style.removeProperty('width');
  } else {
    el.style.height = el.offsetHeight + 'px';
    el.style.width = el.offsetWidth + 'px';
  }

  el.classList.toggle(spinnerClass);
}