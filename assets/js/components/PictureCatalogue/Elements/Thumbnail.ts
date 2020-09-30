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
    this.dispatcher.dispatch(new PictureSelected(
      this.id,
      this.dom.style.backgroundImage.split('"')[1]
    ));
  }

  public static createDom(id: number, url: string) {
    let el = document.createElement('div');
    el.classList.add('selector-thumbnail');
    el.style.backgroundImage = `url('${url}')`;
    el.innerHTML = `<input type="hidden" value="${id}">`

    return el;
  } 
}