import Subscriber from "../../helpers/Subscriber/Subscriber";
import VotingValue from "./VotingValue";
import PriceAdded from './Event/PriceAdded';
import PriceUpdated from './Event/PriceUpdated';

export default class Price extends VotingValue implements Subscriber{
  public subscribedEvents = {
    [PriceAdded.name]: this.onPriceAdded.bind(this),
    [PriceUpdated.name]: this.onPriceUpdated.bind(this)
  }

  constructor(dom: HTMLElement) {
    super(dom);
  }

  public onPriceAdded(event: PriceAdded) {
    this.updateValue(event.price);
    
    this.dom.innerHTML = this.show();
  }

  public onPriceUpdated(event: PriceUpdated) {
    this.updateValue(event.newPrice, event.oldPirce)

    this.dom.innerHTML = this.show();
  }

  protected show() {
    const {value, votes} = this;

    return `
    <strong class="price-value">${value.toFixed(2)}</strong>
    <span>€</span>
    <small class="vote-number">(${votes})</small>`
  }

  protected update() {
    let ratingValue = this.dom.querySelector('.price-value');
    if (ratingValue) {
      this.value = parseFloat(ratingValue.innerHTML);
      this.votes = parseInt(this.dom.querySelector('.vote-number').innerHTML.split(/\(|\)/)[1]);
    }
  }
}