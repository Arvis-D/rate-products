export default class RatingUpdated {
  constructor (
    public readonly oldRating: number,
    public readonly newRating: number
  ) { }
}