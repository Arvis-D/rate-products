import PictueCatalogue from './components/PictureCatalogue/index';
import Dispatcher from './helpers/Subscriber/Dispatcher';
import Input from './components/Form/Input';
import Submit from './components/Form/Submit';
import NumericSize from './components/Form/Validator/NumericSize';
import Numeric from './components/Form/Validator/Numeric';
import Form from './components/Form/Form';
import Price from './components/Stats/Price';
import Rating from './components/Stats/Rating';
import SubmitStats from './components/Stats/SubmitStats';

{
  let catalogueDom = document.querySelector('.picture-catalogue') as HTMLElement;

  let catalogue;
  if (catalogueDom) {
    catalogue = new PictueCatalogue(
      'product',
      catalogueDom,
      new Dispatcher()
    );
  }
}

{
  let dispatcher = new Dispatcher;

  let priceInput = new Input(document.querySelector('.input-price'), dispatcher, true, false);
  priceInput.addValidators([new Numeric('')]);

  let ratingInput = new Input(document.querySelector('.input-rating'), dispatcher, true, false);
  ratingInput.addValidators([new Numeric(''), new NumericSize('', 0, 5)]);

  let form = new Form(dispatcher);
  dispatcher.addSubscriber(form);
  form.add([priceInput, ratingInput]);
  form.init();

  let price = new Price(document.querySelector('.price'))
  let rating = new Rating(document.querySelector('.rating'))
  dispatcher.addSubscriber(price);
  dispatcher.addSubscriber(rating);

  let submitStats = new SubmitStats(
    new Submit(document.querySelector('.save-stats').firstElementChild as HTMLButtonElement),
    priceInput,
    ratingInput,
    dispatcher
  )
  
  dispatcher.addSubscriber(submitStats.submit);
}