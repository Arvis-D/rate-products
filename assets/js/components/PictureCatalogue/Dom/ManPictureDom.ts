import BaseDom from '../../../helpers/BaseDom';

export default class MainPictureDom extends BaseDom {
  public picture: HTMLElement;

  constructor (pictureMain: HTMLElement) {
    super(pictureMain);
  }

  public update() {
    this.picture = this.one('.picture');
  }
}