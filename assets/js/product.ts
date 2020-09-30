import PictueCatalogue from './components/PictureCatalogue/index';
import Dispatcher from './helpers/Subscriber/Dispatcher';


let catalogue = new PictueCatalogue(
  'product',
  document.querySelector('.picture-catalogue'),
  new Dispatcher()
);




