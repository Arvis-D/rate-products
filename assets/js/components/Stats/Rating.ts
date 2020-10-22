import Subscriber from '../../helpers/Subscriber/Subscriber';
import RatingAdded from './Event/RatingAdded';
import RatingUpdated from './Event/RatingUpdated';
import VotingValue from './VotingValue';

export default class Rating extends VotingValue implements Subscriber{
  public subscribedEvents = {
    [RatingAdded.name]: this.onRatingAdded.bind(this),
    [RatingUpdated.name]: this.onPriceUpdated.bind(this)
  }

  constructor(dom: HTMLElement) {
    super(dom);
  }

  public onRatingAdded(event: RatingAdded) {
    this.updateValue(event.rating);
    
    this.dom.innerHTML = this.show();
  }

  public onPriceUpdated(event: RatingUpdated) {
    this.updateValue(event.newRating, event.oldRating);
    
    this.dom.innerHTML = this.show();
  }

  protected show() {
    const {value, votes} = this;

    let color = '';
    if (value > 0) {
      color = 'text-danger';
    }
    if (value > 2.5) {
      color = 'text-warning';
    } 
    if (value > 4) {
      color = 'text-success';
    }

    return `
      <strong class="${color} rating-value">${value.toFixed(2)}</strong>
      <small>/</small>
      <small>5</small> 
      <small class="vote-number">(${votes})</small>`
  }

  protected update() {
    let ratingValue = this.dom.querySelector('.rating-value');
    if (ratingValue) {
      this.value = parseFloat(ratingValue.innerHTML);
      this.votes = parseInt(this.dom.querySelector('.vote-number').innerHTML.split(/\(|\)/)[1]);
    }
  }
}