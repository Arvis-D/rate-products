import Event from './Event';

export default interface Subscriber {
  subscribedEvents: Array<string>;

  actOnEvent(event: Event): void;
}