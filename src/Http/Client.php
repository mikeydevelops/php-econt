<?php

namespace MikeyDevelops\Econt\Http;

use MikeyDevelops\Econt\Exceptions\HttpException;

abstract class Client implements Client
{
    /**
     * The user agent to use for requests.
     */
    protected ?string $userAgent = null;

    /**
     * The cached composer file.
     */
    protected array $composer = [];

    /**
     * The base url to the API. If not set, all requests must have absolute urls.
     *
     * @var string|null
     */
    protected ?string $baseUrl = null;

    /**
     * List of global headers that will be sent with each of the requests.
     *
     * @var array
     */
    protected array $headers = [];

    /**
     * Create new instance of HttpClient.
     *
     * @param  string|null  $baseUrl  The base url for all relative requests.
     */
    public function __construct(?string $baseUrl = null)
    {
        $this->baseUrl = $baseUrl;
        $this->userAgent = $this->makeUserAgent();
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
    abstract public function request(string $method, string $uri, array $data = [], array $headers = []): Response;

    /**
     * Prepare and validate a request for curl.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return array{string,string,string[],string}
     */
    protected function prepare(string $method, string $uri, array $data = [], array $headers = []): array
    {
        $method = $this->prepareMethod($method);

        $url = $this->url($uri, $data['query'] ?? []);

        list($type, $body) = $this->prepareBody($data);

        $headers = $this->prepareHeaders($headers, $body ? [
            'Content-Type' => $type,
        ] : []);

        return [$method, $url, $headers, $body];
    }

    /**
     * Prepare and validate given http method.
     *
     * @param  string  $method
     * @return string
     */
    public function prepareMethod(string $method): string
    {
        $method = strtoupper($original = $method);

        $supported = [
            'GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE',
        ];

        if (! in_array($method, $supported)) {
            throw HttpException::unsupportedMethod($original, $supported);
        }

        return $method;
    }

    /**
     * Get complete url if there is $baseUrl set for the client and given uri is relative.
     *
     * @param  string  $uri  The url. Can be relative if $baseUrl has been set.
     * @param  array  $query  Additional query variables to merge into the url.
     * @return string
     */
    public function url(string $uri, array $query = []): string
    {
        $url = $this->baseUrl;

        if (substr($uri, 0, 4) === 'http') {
            $url = $uri;
            $uri = '';
        }

        $parts = parse_url($url) ?: [];
        $uriParts = parse_url($uri) ?: [];
        $url = "$parts[scheme]://$parts[host]";

        if (isset($parts['port'])) {
            $url .= ':' . $parts['port'];
        }

        $path = $parts['path'] ?? '';

        // if given url is relative and starts with / we will override the path.
        if (substr($uri, 0, 1) == '/') {
            $path = $uriParts['path'];
        } else {
            if (substr($path, -1) != '/' && ! empty($uri)) {
                $path .= '/';
            }

            $path .= $uriParts['path'] ?? '';
        }

        $url .= $path;

        parse_str($parts['query'] ?? '', $baseQuery);
        parse_str($uriParts['query'] ?? '', $uriQuery);
        $query = array_merge_recursive($baseQuery, $uriQuery, $query);

        if (! empty($query)) {
            $query = http_build_query($query);
            $url .= '?' . $query;
        }

        $fragment = $uriParts['fragment'] ?? $parts['fragment'] ?? null;

        if (! is_null($fragment)) {
            $url .= '#' . $fragment;
        }

        return $url;
    }

    /**
     * Prepare request body from request options.
     *
     * @param  array  $data
     * @return array{string,string}
     */
    protected function prepareBody(array $data = []): array
    {
        if (isset($data['json'])) {
            $json = json_encode($data['json']);

            if (json_last_error() != JSON_ERROR_NONE) {
                throw HttpException::jsonEncodeFailed(json_last_error(), json_last_error_msg());
            }

            return ['application/json', $json];
        }

        if (isset($data['form'])) {
            return ['application/x-www-form-urlencoded', http_build_query($data['form'])];
        }

        return ['text/plain', $data['body'] ?? ''];
    }

    /**
     * Prepare the given headers array for sending a request.
     * Merges instance headers with given headers array.
     * Adds User-Agent if missing.
     *
     * @param  array  $headers
     * @param  array  $merge  Additional headers to add.
     * @return array
     */
    protected function prepareHeaders(array $headers = [], array $merge = []): array
    {
        $headers = array_merge($this->headers, $headers, $merge);

        if (! isset($headers['User-Agent'])) {
            $headers['User-Agent'] = $this->getUserAgent();
        }

        return array_map(function ($value, $key) {
            return "$key: $value";
        }, $headers, array_keys($headers));
    }

    /**
     * Get the current user agent.
     */
    public function getUserAgent(): string
    {
        if (! isset($this->userAgent)) {
            $this->userAgent = $this->makeUserAgent();
        }

        return $this->userAgent;
    }

    /**
     * Set the user agent for the client.
     */
    public function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Construct user agent based on environment.
     * Includes composer package name and version and php version.
     *
     * @return string
     */
    protected function makeUserAgent(): string
    {
        $pluginName = $this->composer('name');
        $pluginVersion = $this->composer('version');

        $phpVersion = phpversion();

        return "$pluginName/$pluginVersion PHP/$phpVersion";
    }

    /**
     * Change the base url of the client.
     *
     * @param  string|null  $url
     * @return static
     */
    public function setBaseUrl(?string $url = null): self
    {
        $this->baseUrl = $url;

        return $this;
    }

    /**
     * Get the current base url.
     *
     * @return string|null
     */
    public function getBaseUrl(): ?string
    {
        return $this->baseUrl;
    }

    /**
     * Get the client headers.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set the client headers.
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set specified header. If value is null, the header will be removed.
     */
    public function setHeader(string $name, $value): self
    {
        if (is_null($value)) {
            return $this->removeHeader($name);
        }

        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Remove header with given name from client headers.
     */
    public function removeHeader(string $name): self
    {
        unset($this->headers[$name]);

        return $this;
    }

    /**
     * Get an item from the app composer.json.
     */
    public function composer(?string $key = null, $default = null): mixed
    {
        if (empty($this->composer)) {
            $composerPath = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'composer.json';
            $this->composer = json_decode(file_get_contents($composerPath), true);
        }

        if (is_null($key)) {
            return $this->composer;
        }

        // dot notation
        $current = $this->composer;
        $key = strtok($key, '.');

        while ($key !== false) {
            if (! isset($current[$key])) {
                return $default;
            }

            $current = $current[$key];
            $key = strtok('.');
        }

        return $current;
    }
}
