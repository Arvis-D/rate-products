export default abstract class Results {
  protected results: HTMLElement;

  constructor(
    /**
     * below which results will be displayed
     */

    protected reference: HTMLElement
  ) { }

  abstract display(data: Array<any>, wildcard?: string): void;

  abstract hide(): void;

  protected getRect() {
    return this.reference.getBoundingClientRect();
  }

  protected highlightWildcard(result: string, wildcard: string) {
    return result.replace(wildcard, `<span>${wildcard}</span>`);
  }
}