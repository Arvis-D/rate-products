export default class PriceUpdated {
  constructor (
    public readonly oldPirce: number,
    public readonly newPrice: number
  ) { }
}