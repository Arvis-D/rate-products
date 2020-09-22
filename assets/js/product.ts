import ImageFormDom from './components/PictureCatalogue/Dom/ImageFormDom';
import PictureSelector from './components/PictureCatalogue/PictureSelector';
import ImageForm from './components/PictureCatalogue/ImageForm';
import PictureSelectorDom from './components/PictureCatalogue/Dom/PictureSelectorDom';
import MainPicture from './components/PictureCatalogue/MainPicture';
import MainPictureDom from './components/PictureCatalogue/Dom/ManPictureDom';

let catalogueDom = document.querySelector('.picture-catalogue');
let imageformDom = new ImageFormDom(catalogueDom.querySelector('.image-upload'));
let pictureSelectorDom = new PictureSelectorDom(catalogueDom.querySelector('.picture-selector'));
let mainPictureDom = new MainPictureDom(document.querySelector('.picture-main'));

let catalogue = new PictureSelector(pictureSelectorDom);
let imageForm = new ImageForm(imageformDom);
let mainPicture = new MainPicture(mainPictureDom);