import Ajax from '../../../helpers/Ajax';
import ResultFetcher from './ResultFetcher';

export default class TypeFetcher implements ResultFetcher {
  public fetchResults(value: string) {
    return Ajax.create()
      .methodGet()
      .setUrl(`/api/product/type/get/${value}`)
      .send()
      .then(res => (res.status === 200 ? res.json() : null))
  }
}