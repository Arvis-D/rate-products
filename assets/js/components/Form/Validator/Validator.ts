export default interface Validator {
  validate(value?: string): boolean | Promise<boolean>

  getErrorMessage(): string;
}