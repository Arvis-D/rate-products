import Subscriber from '../../helpers/Subscriber/Subscriber';
import LikeEvent from './LikeEvent';
import { likeEvents } from './events';
import Request from '../../helpers/Request';
import csrf from '../../helpers/Subscriber/csrf';
import { spinnerType, toggleSpinner } from '../../helpers/spinner';

export default class LikeControls  implements Subscriber{
  private thumbUp: HTMLElement;
  private thumbDown: HTMLElement;
  private id: number;
  private likes: number;
  private dislikes: number;
  private csrf: string;
  public subscribedEvents = [likeEvents.infoRecieved];

  constructor(
    private url: string,
    private dom: HTMLElement
  ) {
    this.thumbDown = this.dom.querySelector('.thumb-down');
    this.thumbUp = this.dom.querySelector('.thumb-up');
    this.thumbDown.addEventListener('click', () => {this.handleDislike()});
    this.thumbUp.addEventListener('click', () => {this.handleLike()});

    this.likes = parseInt(this.thumbUp.children[1].innerHTML);
    this.dislikes = parseInt(this.thumbDown.children[1].innerHTML);

    this.csrf = csrf();
    this.id = parseInt(this.dom.querySelector('.subject-id').innerHTML);
  }

  private handleDislike() {
    this.submit(false);
  }

  private handleLike() {
    this.submit(true);
  }

  private async submit(like: boolean) {
    toggleSpinner(this.dom, spinnerType.small);
    let success = await this.postLike(like);

    if (success) {
      this.toggle(like);
    }

    toggleSpinner(this.dom, spinnerType.small);
  }

  private toggle(like: boolean) {
    if (like) {
      if (this.isActive(this.thumbDown)) {
        console.log('t')
        this.toggleDislike()
      }
      this.toggleLike();
    } else {
      if (this.isActive(this.thumbUp)) {
        console.log('d')
        this.toggleLike();
      }
      this.toggleDislike();
    }
    this.changeLikeNumber();
  }

  private toggleLike() {
    this.likes += (this.thumbUp.classList.toggle('active') ? 1 : -1);
  }

  private toggleDislike() {
    this.dislikes += (this.thumbDown.classList.toggle('active') ? 1 : -1);
  }
  
  private isActive(el: HTMLElement) {
    return el.classList.contains('active');
  }

  private postLike(like: boolean) {
    return Request.create()
    .add('subject-id', this.id.toString())
    .add('csrf', this.csrf)
    .add('like', (like ? '1' : '0'))
    .setUrl(this.url)
    .send()
    .then(res => res.ok)
    .catch(err => console.log(err));
  }

  private changeLikeNumber() {
    this.thumbUp.children[1].innerHTML = this.likes.toString();
    this.thumbDown.children[1].innerHTML = this.dislikes.toString();
  }

  public actOnEvent(event: LikeEvent) {
    this.likes = event.likes;
    this.dislikes = event.dislikes;
    this.changeLikeNumber();
    this.id = event.id;
  }
}