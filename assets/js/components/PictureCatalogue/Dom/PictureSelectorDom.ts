import BaseDom from '../../../helpers/BaseDom';

export default class PictureSelectorDom extends BaseDom {
  public thumbnails: NodeListOf<HTMLElement>;

  constructor (pictures: HTMLElement) {
    super(pictures);
  }

  public update() {
    this.thumbnails = this.many('.selector-thumbnail');
  }
}