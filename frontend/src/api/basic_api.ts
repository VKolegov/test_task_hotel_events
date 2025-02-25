import HttpError from './http_error.ts';

export const baseURL = import.meta.env.VITE_API_URL || "http://localhost";

const basicHeaders = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
};

type HttpMethod = 'GET' | 'POST' | 'PUT' | 'DELETE';

export async function makeRequest(method: HttpMethod, url: string, data?: Record<string, any>) {

    const isGetRequest = method === 'GET';

    if (isGetRequest && data) {
        url = url + '?' + buildQueryString(data); 
    }

    const headers = basicHeaders;

    const request = new Request(url, {
        method: method,
        body: !isGetRequest && data ? JSON.stringify(data) : null,
        headers: headers,
    });

    const response = await fetch(request);

    if (response.status <= 300) {
        return await response.json();
    }

    // Попробуем прочитать тело ответа (если доступно)
    let errorDetails = null;
    let responseBody = null;

    try {
        const contentType = response.headers.get('Content-Type') || '';
        if (contentType.includes('application/json')) {
            responseBody = await response.json();
        } else {
            errorDetails = await response.text();
        }
    } catch (error) {
        console.error('Ошибка обработки ответа:', error);
    }

    throw new HttpError(response.status, url, response.statusText, errorDetails,
        responseBody);
}

function buildQueryString(data: Record<string, any>): string {
  const queryStringBuilder = new URLSearchParams();  
  for (let [k,v] of Object.entries(data)) {
    if (Array.isArray(v)) {
      v.forEach(el => queryStringBuilder.append(`${k}[]`, el));
    } else if (v !== null) {
      queryStringBuilder.append(k, v);
    }
  };

  return queryStringBuilder.toString();
}

export async function getRequest(url: string, params?: Record<string, any>) {
    return await makeRequest('GET', url, params);
}

export async function postRequest(url, data) {
    return await makeRequest('POST', url, data);
}

export async function patchRequest(url, data) {
    return await makeRequest('PATCH', url, data);
}

export async function putRequest(url, data) {
    return await makeRequest('PUT', url, data);
}
