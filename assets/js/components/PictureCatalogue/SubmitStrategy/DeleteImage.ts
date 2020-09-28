import SubmitStrategy from './SubmitStrategy';
import Request from '../../../helpers/Request';

enum Subject {
  product = 'product'
}

export default class DeleteImage implements SubmitStrategy{
  constructor (
    private imageId: number, 
    private csrf: string, 
    private subject: Subject
  ) { }

  public submit() {
    return Request.create()
      .setUrl(`/api/${this.subject}/picture/delete`)
      .add('csrf', this.csrf)
      .add('picture-id', this.imageId.toString())
      .send();
  }
}