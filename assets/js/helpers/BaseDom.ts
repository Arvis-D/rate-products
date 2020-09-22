export default abstract class BaseDom {
  constructor (public base: HTMLElement) {
    this.update();
  };

  public abstract update(): void;

  public one(name: string): HTMLElement {
    return this.base.querySelector(name) as HTMLElement;
  }

  public many(name: string): NodeListOf<HTMLElement> {
    return this.base.querySelectorAll(name) as NodeListOf<HTMLElement>;
  }
}