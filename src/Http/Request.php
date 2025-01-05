<?php

namespace MikeyDevelops\Econt\Http;

class Request
{
    /**
     * The request HTTP Method.
     *
     * @var string
     */
    protected string $method = 'GET';

    /**
     * The url to make a request to.
     *
     * @var string
     */
    protected string $url;

    /**
     * The request body.
     *
     * @var mixed
     */
    protected $body = null;

    /**
     * The request headers.
     *
     * @var array
     */
    protected array $headers = [];

    /**
     * The HTTP protocol version for the request.
     *
     * @var string
     */
    protected string $protocolVersion = '1.1';

    /**
     * The request options.
     *
     * @var array
     */
    protected array $options = [];

    /**
     * The related response.
     *
     * @var \MikeyDevelops\Econt\Http\Response|null
     */
    protected ?Response $response;

    /**
     * Create new instance of request.
     *
     * @param  string  $method
     * @param  string  $url
     * @param  mixed  $body
     * @param  array  $headers
     */
    public function __construct(string $method, string $url, $body = null, array $headers = [])
    {
        $this->method = $method;
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Set the request method.
     *
     * @param  string  $method
     * @return static
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get the url of the request.
     *
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }

    /**
     * Set the request url.
     *
     * @param  string  $url
     * @return static
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * The request headers.
     *
     * @return array
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /**
     * Set the request headers.
     *
     * @param  array  $headers
     * @return static
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Get the body of the request.
     *
     * @return mixed
     */
    public function body(): mixed
    {
        return $this->body;
    }

    /**
     * Set the request body.
     *
     * @param  mixed  $body
     * @return static
     */
    public function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the request HTTP protocol version.
     *
     * @return string
     */
    public function protocol(): string
    {
        return $this->protocolVersion;
    }

    /**
     * Set the request HTTP protocol version.
     *
     * @param  string  $method
     * @return static
     */
    public function setProtocolVersion(string $version): self
    {
        $this->protocolVersion = $version;

        return $this;
    }

    /**
     * Get the options for the request.
     *
     * @return array
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * Set the request options.
     *
     * @param  array  $options
     * @return static
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get an option from the request options.
     *
     * @param  string  $key  The option key.
     * @param  mixed  $default  The default value to be returned if option key does not exist.
     * @return mixed
     */
    public function option(string $key, $default = null): mixed
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * Set a request option.
     *
     * @param  string  $key  The key of the option.
     * @param  mixed  $value  Set the value of the option.
     * @return static
     */
    public function setOption(string $key, $value): self
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * Get the related response.
     *
     * @return \MikeyDevelops\Econt\Http\Response
     */
    public function response(): ?Response
    {
        return $this->response;
    }

    /**
     * Set the related response.
     *
     * @param  \MikeyDevelops\Econt\Http\Response  $response
     * @return static
     */
    public function setResponse(Response $response): self
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Convert the request to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'protocolVersion' => $this->protocolVersion,
            'method' => $this->method,
            'url' => $this->url,
            'headers' => $this->headers,
            'body' => $this->body,
            'options' => $this->options,
        ];
    }

    /**
     * Convert the request to json string.
     *
     * @param  integer  $flags  [optional] Bitmask consisting of JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP, JSON_HEX_APOS, JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES, JSON_FORCE_OBJECT, JSON_UNESCAPED_UNICODE. JSON_THROW_ON_ERROR The behaviour of these constants is described on the JSON constants page.
     * @param  int  $depth [optional] Set the maximum depth. Must be greater than zero.
     * @return string
     */
    public function toJson(int $flags = 0, int $depth = 512): string
    {
        return json_encode($this->toArray(), $flags, $depth);
    }

    /**
     * Convert the request to string.
     *
     * @return string
     */
    public function toString(): string
    {
        $parts = [];

        $urlParts = parse_url($this->url);
        $path = $urlParts['path'];

        if (isset($urlParts['query'])) {
            $path .= '?' . $urlParts['query'];
        }

        if (isset($urlParts['fragment'])) {
            $path .= '#' . $urlParts['fragment'];
        }

        $host = $urlParts['host'];

        $parts[] = "$this->method $path HTTP/$this->protocolVersion";
        $parts[] = "Host: $host";
        $parts = array_merge($parts, array_map(function ($key, $value) {
            return "$key: $value";
        }, array_keys($this->headers), $this->headers));

        if (isset($this->body)) {
            $parts[] = 'Content-Length: ' . mb_strlen($this->body);

            $parts[] = "\n";
            $parts[] = $this->body;
        }

        return implode("\n", $parts);
    }

    /**
     * PHP Magic function to treat the object as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
