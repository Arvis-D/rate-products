import Input from './components/Form/Input';
import Dispatcher from './helpers/Subscriber/Dispatcher';
import Unique from './components/Form/Validator/Unique';
import Numeric from './components/Form/Validator/Numeric';
import NumericSize from './components/Form/Validator/NumericSize';
import Form from './components/Form/Form';
import Submit from './components/Form/Submit';
import ImageInput from './components/PictureCatalogue/Elements/ImageInput';
import PreUploadPic from './components/PictureCatalogue/Elements/PreUploadPic';
import SearchInput from './components/Search/SearchInput';
import TypeResults from './components/Search/Result/TypeResults';
import TypeId from './components/Search/TypeId';
import TypeFetcher from './components/Search/Result/TypeFetcher';

let dispatcher = new Dispatcher();
let name = new Input(document.querySelector('.input-name'), dispatcher);
let price = new Input(document.querySelector('.input-price'), dispatcher, true);
let rating = new Input(document.querySelector('.input-rating'), dispatcher, true);

name.addAsyncValidator([new Unique('Product name', name.input, 'product', 'name')]);
price.addValidators([new Numeric('Price')]);
rating.addValidators([new Numeric('Rating'), new NumericSize('Rating', 0, 5)]);

let submit = new Submit(document.querySelector('.submit'));
dispatcher.addSubscriber(submit);

let form = new Form(dispatcher);
dispatcher.addSubscriber(form);
form.add([name, price, rating]);
form.init();

let image = new ImageInput(document.querySelector('.image-input'), dispatcher);
let showcase = new PreUploadPic(document.querySelector('.upload-showcase'));
dispatcher.addSubscriber(showcase);

let search = new SearchInput(dispatcher, document.querySelector('#form-type'));
search.setResultFetcher(new TypeFetcher);
search.setResultDisplay(new TypeResults(dispatcher, document.querySelector('#form-type')));
dispatcher.addSubscriber(search);
dispatcher.addSubscriber(new TypeId(document.querySelector('input[name="type-id"]')));