let form = document.querySelector('#create-product');
let attributesInput = form.querySelector('#attributes');
let selectType = form.querySelector('.type-select');

const dynamicFormParts = {
  furniture: form.querySelector('#dynamic-furniture'), 
  cd: form.querySelector('#dynamic-cd'),
  book: form.querySelector('#dynamic-book')
}

function reset() {
  for (let part in dynamicFormParts) {
    if (dynamicFormParts.hasOwnProperty(part)) {
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
    el.setAttribute('required', '');
  });
});

form.addEventListener('submit', () => {
  let attributes = {};
  dynamicFormParts[selectType.value].querySelectorAll('input').forEach(el => {
    attributes[el.name] = el.value;
  });

  for (let part in dynamicFormParts) {
    if (dynamicFormParts.hasOwnProperty(part)) {
      dynamicFormParts[part].querySelectorAll('input').forEach(element => {
        element.setAttribute('disabled', 'disabled');
      });
    }
  }

  attributesInput.value = JSON.stringify(attributes);
});
