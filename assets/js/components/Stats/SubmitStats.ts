import Ajax from '../../helpers/Ajax';
import csrf from '../../helpers/Subscriber/csrf';
import Dispatcher from '../../helpers/Subscriber/Dispatcher';
import PriceAdded from './Event/PriceAdded';
import RatingAdded from './Event/RatingAdded';
import { toggleSpinner, spinnerType } from '../../helpers/spinner';
import Submit from '../Form/Submit';
import Input from '../Form/Input';
import RatingUpdated from './Event/RatingUpdated';
import PriceUpdated from './Event/PriceUpdated';

export default class SubmitStats {
  private productId: number = null;

  constructor (
    public submit: Submit,
    public price: Input,
    public rating: Input,
    private dispatcher: Dispatcher
  ) {
    this.productId = parseInt((this.submit.dom.nextElementSibling as HTMLInputElement).value);
    this.submit.dom.addEventListener('click', () => {this.save()});
  }

  public async save() {
    toggleSpinner(this.submit.dom, spinnerType.small);
    const res = await this.postStats();
    if (res.success) {
      if (res.rating.action === 'updated') {
        this.dispatcher.dispatch(new RatingUpdated(parseFloat(res.rating.old), parseFloat(this.rating.input.value)))
      } else {
        this.dispatcher.dispatch(new RatingAdded(parseFloat(this.rating.input.value)))
      }

      if (res.price.action === 'updated') {
        this.dispatcher.dispatch(new PriceUpdated(parseFloat(res.price.old) / 100, parseFloat(this.price.input.value)))
      } else {
        this.dispatcher.dispatch(new PriceAdded(parseFloat(this.price.input.value)))
      }
    }

    toggleSpinner(this.submit.dom, spinnerType.small);
  }

  private postStats () {
    return Ajax.create()
      .add('csrf', csrf())
      .add('rating', this.rating.input.value)
      .add('price', this.price.input.value)
      .add('id', this.productId.toString())
      .setUrl('/api/product/stats/store')
      .send()
      .then(res => (res.status === 200 ? res.json() : {success: false}));
  }
}