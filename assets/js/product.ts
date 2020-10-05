import PictueCatalogue from './components/PictureCatalogue/index';
import Dispatcher from './helpers/Subscriber/Dispatcher';

let catalogueDom = document.querySelector('.picture-catalogue') as HTMLElement;

let catalogue;
if (catalogueDom) {
  catalogue = new PictueCatalogue(
    'product',
    catalogueDom,
    new Dispatcher()
  );
}