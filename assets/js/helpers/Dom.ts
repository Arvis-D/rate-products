export default class Dom {
  public static all(query: string) {
    return document.querySelectorAll(query);
  }
  public static one(query: string) {
    return document.querySelector(query);
  }
}