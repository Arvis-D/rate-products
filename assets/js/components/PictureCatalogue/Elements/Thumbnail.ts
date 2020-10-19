import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import PictureSelected from '../Event/PictureSelected';

export default class Thumbnail {
  public id: number;

  constructor(
    public dom: HTMLElement,
    private dispatcher: Dispatcher
  ) {
    this.id = parseInt(this.dom.querySelector('input').value);
    this.dom.addEventListener('click', () => {this.choosePicture()});
  }
  
  private choosePicture() {
    const img = this.dom.firstElementChild as HTMLImageElement;

    this.dispatcher.dispatch(new PictureSelected(
      this.id,
      img.getAttribute('src')
    ));
  }

  public static createDom(id: number, url: string) {
    let el = document.createElement('div');
    el.classList.add('selector-thumbnail');
    let img = document.createElement('img');
    img.setAttribute('src', url);
    el.innerHTML = `<input type="hidden" value="${id}">`;
    el.appendChild(img);

    return el;
  } 
}