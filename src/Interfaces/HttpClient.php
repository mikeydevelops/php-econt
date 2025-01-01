<?php

namespace MikeyDevelops\Econt\Interfaces;

use MikeyDevelops\Econt\Http\Response;

interface HttpClient
{
    /**
     * Make a request to given url.
     *
     * @param  string  $method  The HTTP method.
     * @param  string  $uri  The url. Can be relative if $baseUrl has been set.
     * @param  array  $data  The data to be sent with the request.
     * @param  array  $headers Additional headers to send with the request.
     * @return \MikeyDevelops\Econt\Http\Response The response.
     * @throws \MikeyDevelops\Econt\Exceptions\HttpException
     */
    public function request(string $method, string $uri, array $data = [], array $headers = []): Response;

    /**
     * Change the base url of the client.
     *
     * @param  string|null  $url
     * @return static
     */
    public function setBaseUrl(?string $url = null): self;

    /**
     * Get the current base url.
     *
     * @return string|null
     */
    public function getBaseUrl(): ?string;
}
