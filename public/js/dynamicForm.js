let selectType = document.querySelector('.type-select');

const dynamicFormParts = {
  Furniture: document.querySelector('#dynamic-furniture'), 
  CD: document.querySelector('#dynamic-cd'),
  Book: document.querySelector('#dynamic-book')
}

function reset(){
  for(let part in dynamicFormParts){
    if(dynamicFormParts.hasOwnProperty(part)){
      dynamicFormParts[part].style.display = 'none';
      dynamicFormParts[part].querySelectorAll('input').forEach(el => {
        el.removeAttribute('required');
      });
    }
  }
}

reset();
dynamicFormParts[selectType.value].style.display = 'block';

selectType.addEventListener('change', event => {
  reset();
  dynamicFormParts[event.target.value].style.display = 'block';
  dynamicFormParts[event.target.value].querySelectorAll('input').forEach(el => {
    el.removeAttribute('required');
  });
});
