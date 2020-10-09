import ImageInput from "./components/PictureCatalogue/Elements/ImageInput";
import PreUploadPic from "./components/PictureCatalogue/Elements/PreUploadPic";
import Dispatcher from './helpers/Subscriber/Dispatcher';

let dispatcher= new Dispatcher;
let image = new ImageInput(document.querySelector('.image-input'), dispatcher);
let showcase = new PreUploadPic(document.querySelector('.upload-showcase'));
dispatcher.addSubscriber(showcase);