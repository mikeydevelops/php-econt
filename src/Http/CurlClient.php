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

        array_splice($parts, 2, 0, "curl/$curlVersion");

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
        $request = $this->prepare($method, $uri, $data, $headers);

        $curl = curl_init();

        $headers = array_map(
            function ($key, $value) {
                return "$key: $value";
            },
            array_keys($request->headers()),
            $request->headers()
        );

        curl_setopt_array($curl, [
            CURLOPT_CUSTOMREQUEST => $request->method(),
            CURLOPT_URL => $request->url(),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => $request->option('verify_ssl', true),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
        ]);

        if (! in_array($method, ['GET', 'HEAD'])) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request->body());
        }

        $body = curl_exec($curl);
        $info = curl_getinfo($curl);

        curl_close($curl);

        $headers = preg_split('/\r?\n/', substr($body, 0, $hs = $info['header_size']));

        $response = new Response(substr($body, $hs), $info['http_code'], $headers);

        $response->setRequest($request->setResponse($response));

        // TODO: analyze response, throw exceptions on response errors 400 - 500.

        return $response;
    }
}
