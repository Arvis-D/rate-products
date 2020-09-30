import Subscriber from './Subscriber';
import Event from './Event';

export default class Dispatcher {
  private subscribers: Array<Subscriber> = [];

  public addSubscriber(subscriber: Subscriber) {
    this.subscribers.push(subscriber);
  }

  public dispatch(event: object) {
    let eventName = event.constructor.name;

    console.log('!!DISPATCH!!!', eventName, event);
    this.subscribers.forEach(subscriber => {
      if (eventName in subscriber.subscribedEvents) {
        subscriber.subscribedEvents[eventName](event);
      }
    });
  }
}