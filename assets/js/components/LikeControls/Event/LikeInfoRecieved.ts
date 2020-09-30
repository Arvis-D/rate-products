export default class LikeInfoRecieved {
  constructor (
    public readonly likes: number,
    public readonly dislikes: number,
    public readonly subjectId: number,
    public readonly userLike?: boolean,
  ) { }
}