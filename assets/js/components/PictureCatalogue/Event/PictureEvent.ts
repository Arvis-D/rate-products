import Event from '../../../helpers/Subscriber/Event';

export default interface PictureEvent extends Event {
  readonly url?: string;
  readonly id?: number;
  readonly addedBy?: string;
  readonly timeElapsed?: string;
  readonly userHasLiked?: boolean;
}