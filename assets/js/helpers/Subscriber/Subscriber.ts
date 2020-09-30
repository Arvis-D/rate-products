import Event from './Event';

export default interface Subscriber {
  subscribedEvents: {[eventName: string]: (ev: Event) => void};
}