export async function ajaxForm(form: HTMLFormElement) {
  return await fetch(form.getAttribute('action'), {
    method: form.getAttribute('method'),
    credentials: 'same-origin',
    body: new FormData(form)
  });
}