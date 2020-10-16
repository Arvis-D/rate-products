export interface ScrollRect {
  x: number,
  y: number,
  width: number,
  height: number
}


export function scrollRect(el: HTMLElement): ScrollRect {
  let rect = el.getBoundingClientRect(),
  scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
  scrollTop = window.pageYOffset || document.documentElement.scrollTop;

  return {
    y: rect.top + scrollTop, 
    x: rect.left + scrollLeft,
    height: rect.height,
    width: rect.width
  };
}