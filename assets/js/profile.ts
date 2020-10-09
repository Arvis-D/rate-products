import Form from "./components/Form/Form";
import Input from "./components/Form/Input";
import Submit from "./components/Form/Submit";
import Email from "./components/Form/Validator/Email";
import Length from "./components/Form/Validator/Length";
import Repeat from "./components/Form/Validator/Repeat";
import Unique from './components/Form/Validator/Unique';
import ImageInput from "./components/PictureCatalogue/Elements/ImageInput";
import PreUploadPic from "./components/PictureCatalogue/Elements/PreUploadPic";
import Dispatcher from './helpers/Subscriber/Dispatcher';

let dispatcher = new Dispatcher;
let username = new Input(document.querySelector('.input-username'), dispatcher);
let newPassword = new Input(document.querySelector('.input-new-password'), dispatcher, true);
let email = new Input(document.querySelector('.input-email'), dispatcher);
let repeat = new Input(document.querySelector('.input-repeat-password'), dispatcher, true);

username.addValidators([new Length('Username', 5, 255)]);
username.addAsyncValidator([
  Unique.create('Username', username.input, 'user', 'name').setdoNotCheck(username.input.value)
]);

Unique.create('Username', username.input, 'user', 'name').setdoNotCheck(username.input.value)

email.addValidators([
  new Email, 
  new Length('Email', 0, 255)
]);

email.addAsyncValidator([
  Unique.create('Email', email.input, 'user', 'email').setdoNotCheck(email.input.value)
]);

newPassword.addValidators([new Length('Password', 7)]);
repeat.addValidators([new Repeat(newPassword, 'Password')])

let button  = new Submit(document.querySelector('.submit'));
dispatcher.addSubscriber(button);

let image = new ImageInput(document.querySelector('.image-input'), dispatcher);
let showcase = new PreUploadPic(document.querySelector('.upload-showcase'));
dispatcher.addSubscriber(showcase);

let form = new Form(dispatcher);
form.add([username, newPassword, repeat, email]);
dispatcher.addSubscriber(form);
form.init();


console.log(form);