export default interface SubmitStrategy {
  submit(): Promise<Response>
}