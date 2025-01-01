<?php

namespace MikeyDevelops\Econt\Http;

use MikeyDevelops\Econt\Http\Client;
use MikeyDevelops\Econt\Http\Response;

class CurlClient extends Client
{
    /**
     * Construct user agent based on environment.
     * Includes composer package name and version, curl version and php version.
     *
     * @return string
     */
    protected function makeUserAgent(): string
    {
        $parts = explode(' ', parent::makeUserAgent());

        $curlVersion = curl_version()['version'];

        array_splice($parts, 1, 0, "(curl $curlVersion)");

        return implode(' ', $parts);
    }

    /**
     * Make a request to given url.
     *
     * @param  string  $method  The HTTP method.
     * @param  string  $uri  The url. Can be relative if $baseUrl has been set.
     * @param  array  $data  The data to be sent with the request.
     * @param  array  $headers Additional headers to send with the request.
     * @return \MikeyDevelops\Econt\Response The response.
     */
    public function request(string $method, string $uri, array $data = [], array $headers = []): Response
    {
        list($method, $url, $headers, $body) = $this->prepare($method, $uri, $data, $headers);

        $request = curl_init();

        curl_setopt_array($request, [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => $data['verify_ssl'] ?? true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
        ]);

        if (! in_array($method, ['GET', 'HEAD'])) {
            curl_setopt($request, CURLOPT_POSTFIELDS, $body);
        }

        $body = curl_exec($request);
        $info = curl_getinfo($request);

        curl_close($request);

        $headers = preg_split('/\r?\n/', substr($body, 0, $hs = $info['header_size']));

        $response = new Response(substr($body, $hs), $info['http_code'], $headers);

        // TODO: analyze response, throw exceptions on response errors 400 - 500.

        return $response;
    }
}
