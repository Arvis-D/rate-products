import Dispatcher from '../../helpers/Subscriber/Dispatcher';
import Results from './Result/Results';
import Subscriber from '../../helpers/Subscriber/Subscriber';
import ResultChosen from './Event/ResultChosen';
import EmptyResults from './Event/EmptyResults';
import ResultFetcher from './Result/ResultFetcher';

export default class SearchInput implements Subscriber{
  private memory: {[key: string]: Array<any>} = {};
  private results: Results;
  private fetcher: ResultFetcher;

  public subscribedEvents = {
    [ResultChosen.name]: this.onResultChosen.bind(this)
  };

  constructor (
    private dispatcher: Dispatcher,
    private input: HTMLInputElement,
  ) {
    this.input.addEventListener('input', () => {this.showResults()})
  }

  public setResultDisplay(results: Results) {
    this.results = results;
  }

  private async showResults() {
    let value = this.input.value;
    let {memory, results} = this;

    if (value === '')
      return;

    if (this.checkIfSearchIsPointless()) {
      results.hide();

      return;
    }

    let received = memory[value] = (
      value in memory ? memory[value] : await this.fetcher.fetchResults(value) as Array<any>
    );

    results.display(received, value);

    if (received.length === 0) {
      results.hide();
      this.dispatcher.dispatch(new EmptyResults);
    }
  }

  public setResultFetcher(fetcher: ResultFetcher) {
    this.fetcher = fetcher;
  }

  /**
   * if 'qwert' returns empty results,
   * searching for 'qwerty' is pointless 
   */

  private checkIfSearchIsPointless() {
    let keys = Object.keys(this.memory);

    keys.sort((a, b) => b.length - a.length);

    for (let i = 0; i < keys.length; i++) {
      if (this.input.value.includes(keys[i]) && this.memory[keys[i]].length === 0) {
        return true;
      }
    }

    return false;
  }

  private onResultChosen(event: ResultChosen) {
    this.input.value = event.value;
    this.results.hide();
  }
}