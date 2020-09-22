export function ajaxForm(form: HTMLFormElement) {
  return fetch(form.getAttribute('action'), {
    method: form.getAttribute('method'),
    credentials: 'same-origin',
    body: new FormData(form)
  });
}