export default interface ResultFetcher {
  fetchResults(value: string): Promise<any>;
}