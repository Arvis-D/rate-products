export default class Request {
  private data: FormData = null;
  private url: string = '';
  private method: string = 'POST';

  public send() {
    return fetch(this.url, {
      method: this.method,
      credentials: 'same-origin',
      body: this.data
    });
  }
  
  public add(key: string, value: string): Request {
    this.data = this.data || new FormData;
    this.data.append(key, value);

    return this;
  }

  public setUrl(url: string): Request {
    this.url = url;

    return this;
  }

  public form(form: HTMLFormElement): Request {
    this.data = new FormData(form);

    return this;
  }

  public methodGet(): Request {
    this.method = 'GET';

    return this;
  }

  public methodPost(): Request {
    this.method = 'POST';

    return this;
  }

  public static create(): Request {
    return new Request();
  }
}