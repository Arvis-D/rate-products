let form = document.querySelector('#delete-products');
let idField = form.querySelector('#id-arr');
let checkboxes = document.querySelectorAll('.delete-checkbox');
let idArr = [];

checkboxes.forEach(el => {
  el.addEventListener('change', (ev) => {
    let id = ev.target.name;
    if (ev.target.checked) {
      idArr.push(id);
    } else {
      idArr = idArr.filter(el => el !== id);
    }
  });
});

form.addEventListener('submit', () => {
  idField.value = JSON.stringify(idArr);
  alert(idField.value);
});