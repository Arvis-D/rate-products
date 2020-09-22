import Event from '../../../helpers/Subscriber/Event';

export default interface PictureEvent extends Event {
  pictureUrl: string;
}