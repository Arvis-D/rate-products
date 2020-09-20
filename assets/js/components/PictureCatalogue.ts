export default class PictureCatalogue {
  private thumbnails: NodeListOf<HTMLElement>;
  private picture: HTMLElement;

  constructor (public catalogueDom: HTMLElement) {
    this.thumbnails = this.catalogueDom.querySelectorAll('.selector-thumbnail');
    this.picture = this.catalogueDom.querySelector('.picture');

    this.thumbnails.forEach(e => {
      e.addEventListener('click', (ev) => {this.choosPicture(ev)})
    });
  }

  private choosPicture(ev: Event) {
    let thumbnail = ev.target as HTMLElement
    let cssUrl = thumbnail.style.backgroundImage.replace('--icon', '--size');
    this.picture.style.backgroundImage = cssUrl;
    let url = cssUrl.split('"')[1];
    this.picture.setAttribute('href', url);
  }
}