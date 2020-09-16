import PictureCatalogue from "./components/PictureCatalogue";
import ImageForm from "./components/ImageForm";

let catalogue = new PictureCatalogue(document.querySelector('.picture-catalogue'));
let imageForm = new ImageForm(catalogue.catalogueDom.querySelector('.image-upload'));