export default class HttpError extends Error {

  status: number;
  url: string;
  details: any;
  responseBody: any;

  /**
   * @param {string} [message] - Сообщение об ошибке (необязательно).
   * @param {any} [details] - Дополнительные данные об ошибке (необязательно).
   * @param {any} [responseBody] - Тело ответа (если доступно, может быть JSON).
   */
  constructor(
    status: number,
    url: string,
    message: string = 'HTTP Error',
    details: any = null,
    responseBody: any = null,
  ) {
    super(message);

    // Устанавливаем имя класса для ошибки
    this.name = 'HttpError';

    // HTTP статус-код
    this.status = status;

    // URL запроса
    this.url = url;

    // Дополнительные данные (например, заголовки или сообщение об ошибке)
    this.details = details;

    // Тело ответа (если доступно)
    this.responseBody = responseBody;

    // Удерживаем стек вызовов для дебага (если поддерживается)
    if (Error.captureStackTrace) {
      Error.captureStackTrace(this, HttpError);
    }
  }

  getError() {
    if (this.status < 400) {
      return '';
    }

    return this.responseBody.error ?? '';
  }

  /**
   * Собирает ошибки в карту (Map) по полям (path -> msg).
   */
  getFieldErrors(): Map<string, string> {
    const fieldErrors = new Map();

    if (this.status !== 422) {
      return fieldErrors;
    }

    if (typeof this.responseBody.errors === 'object') {
      for (const [k, v] of Object.entries(this.responseBody.errors)) {
        fieldErrors.set(
          k,
          Array.isArray(v) ? v.join(";\n") : v,
        );
      }
    }

    // TODO: cache

    return fieldErrors;
  }

  getErrorsAsText() {
    const map = this.getFieldErrors();

    let text = this.getError();

    map.forEach((value, key) => {
      if (text) {
        text += ';\n';
      }
      text += `${key}: ${value}`;
    });

    return text;
  }

  toString(): string {
    return this.getErrorsAsText();
  }
}
