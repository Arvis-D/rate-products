export default function csrf(): string {
  let csrf = document.querySelector('.csrf-token') as HTMLInputElement;

  return csrf.value;
}