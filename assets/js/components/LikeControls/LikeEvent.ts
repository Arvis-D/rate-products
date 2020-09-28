import Event from '../../helpers/Subscriber/Event';

export default interface LikeEvent extends Event{
  readonly dislikes?: number,
  readonly likes?: number,
  readonly id?: number,
  readonly userHasLiked?: boolean
}