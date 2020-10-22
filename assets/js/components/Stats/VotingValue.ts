export default abstract class VotingValue {
  protected value: number = null;
  protected votes: number = 0;

  constructor(protected dom: HTMLElement) {
    this.update();
  }

  protected abstract show(): string;

  protected abstract update(): void;

  protected updateValue(newValue: number,  oldValue: number = null): void {
    if (this.value !== null) {
      if (oldValue === null) {
        this.value = ((this.value * this.votes) + newValue) / (this.votes + 1);
        this.votes++;
      } else {
        this.value = (((this.value * this.votes) - oldValue) + newValue) / this.votes;
      }
    } else {
      this.value = newValue;
      this.votes++;
    }
  }
}