import Dispatcher from './helpers/Subscriber/Dispatcher';
import Input from './components/Form/Input';
import Length from './components/Form/Validator/Length';
import Unique from './components/Form/Validator/Unique';
import Form from './components/Form/Form';
import Submit from './components/Form/Submit';
import Repeat from './components/Form/Validator/Repeat';
import Email from './components/Form/Validator/Email';

let dispatcher = new Dispatcher;
let username = new Input(document.querySelector('.input-username'), dispatcher);
let password = new Input(document.querySelector('.input-password'), dispatcher);
let email = new Input(document.querySelector('.input-email'), dispatcher);
let repeat = new Input(document.querySelector('.input-repeat-password'), dispatcher);

username.addValidators([new Length('Username', 5, 255)]);
username.addAsyncValidator([new Unique('Username', username.input, 'user', 'name')]);
email.addValidators([new Email, new Length('Email', 0, 255)]);

password.addValidators([new Length('Password', 7)]);
repeat.addValidators([new Repeat(password, 'Password')])

let button  = new Submit(document.querySelector('.submit'));
dispatcher.addSubscriber(button);

let form = new Form(dispatcher);
form.add([username, password, repeat, email]);
dispatcher.addSubscriber(form);
form.init();