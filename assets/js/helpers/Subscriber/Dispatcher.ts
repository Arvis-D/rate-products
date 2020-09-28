import Subscriber from './Subscriber';
import Event from './Event';

export default class Dispatcher {
  private subscribers: Array<Subscriber> = [];

  public addSubscriber(subscriber: Subscriber) {
    this.subscribers.push(subscriber);
  }

  public dispatch(event: Event) {
    this.subscribers.forEach(subscriber => {
      if (subscriber.subscribedEvents.includes(event.name)) {
        subscriber.actOnEvent(event);
      };
    });
  }
}