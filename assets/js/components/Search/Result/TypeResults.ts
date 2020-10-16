import Results from './Results';
import Dispatcher from '../../../helpers/Subscriber/Dispatcher';
import TypeChosen from '../Event/TypeChosen';
import ResultChosen from '../Event/ResultChosen';
import { scrollRect } from '../../../helpers/position';

export default class TypeResults extends Results {
  constructor(
    private dispatcher: Dispatcher,

    /**
     * @inheritdoc
     */

    reference: HTMLElement
  ) {
    super(reference);

    this.init();
  }

  public hide() {
    this.results.classList.add('hide');
  }

  public display(data: Array<any>, wildcard: string) {
    let { results, dispatcher } = this;
    let frag = new DocumentFragment;
    this.styleResults();

    data.forEach(e => {
      let result = document.createElement('p');
      result.innerHTML = this.highlightWildcard(e.name, wildcard);
      result.addEventListener('click', () => {
        dispatcher.dispatch(new ResultChosen(e.name));
        dispatcher.dispatch(new TypeChosen(e.id)) 
      })
      frag.appendChild(result);
    });

    results.innerHTML = '';
    results.appendChild(frag);
    results.classList.remove('hide');
  }

  private styleResults() {
    let { results } = this;
    const pos = scrollRect(this.reference);

    results.style.left = pos.x + 'px';
    results.style.top = pos.y + pos.height + 'px';
    results.style.width = pos.width + 'px';
  }

  private init() {
    let results = document.createElement('div');
    results.classList.add('search-popup');
    results.classList.add('hide');
    results.classList.add('triangle');
    document.body.appendChild(results);

    this.results = results;
  }
}