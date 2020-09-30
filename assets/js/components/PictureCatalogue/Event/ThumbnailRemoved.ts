export default class ThumbnailRemoved {
  constructor (
    public readonly removedId: number, 
    public readonly newLastId: number
  ) { }
}