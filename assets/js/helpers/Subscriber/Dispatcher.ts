import Subscriber from './Subscriber';
import Event from './Event';

export default class Dispatcher {
  private static subscribers: Array<Subscriber> = [];

  public static addSubscriber(subscriber: Subscriber) {
    Dispatcher.subscribers.push(subscriber);
  }

  public static dispatch(event: Event) {
    Dispatcher.subscribers.forEach(subscriber => {
      if (subscriber.subscribedEvents.includes(event.name)) {
        subscriber.actOnEvent(event);
      };
    });
  }
}