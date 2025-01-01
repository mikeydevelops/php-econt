<?php

namespace MikeyDevelops\Econt\Http;

use MikeyDevelops\Econt\Exceptions\HttpException;

class Response
{
    /**
     * The status code of the response.
     *
     * @var integer
     */
    protected int $status = 200;

    /**
     * The response headers.
     *
     * @var array
     */
    protected array $headers = [];

    /**
     * The content type of the response.
     *
     * @var string
     */
    protected string $contentType = 'text/plain';

    /**
     * The content length of the response.
     *
     * @var integer
     */
    protected int $contentLength = 0;

    /**
     * The response content.
     *
     * @var mixed
     */
    protected $content = null;

    /**
     * Parsed data from response.
     *
     * @var array|null
     */
    protected $data = null;

    /**
     * Create new Response object.
     *
     * @param  mixed  $content
     * @param  integer  $status
     * @param  array  $headers
     */
    public function __construct($content = null, int $status = 200, array $headers = [])
    {
        $this->status = $status;
        $this->headers = $this->parseHeaderLines($headers);
        $this->content = $content;
        $this->contentType = $this->header('content-type') ?? 'text/plain';
        $this->contentLength = strlen($content);
    }

    /**
     * Get the response content.
     *
     * @return mixed
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * Get the status code the server returned.
     *
     * @return integer
     */
    public function status(): int
    {
        return $this->status;
    }

    /**
     * Decode json data from content.
     *
     * @see json_decode
     * @param  boolean  $associative  When true, returned objects will be converted into associative arrays.
     * @param  integer  $depth [optional]  User specified recursion depth.
     * @param  integer  $flags [optional]  Bitmask of JSON decode options: JSON_BIGINT_AS_STRING, JSON_INVALID_UTF8_IGNORE, JSON_INVALID_UTF8_SUBSTITUTE, JSON_OBJECT_AS_ARRAY, JSON_THROW_ON_ERROR
     * @return array|null
     */
    public function json(bool $associative = true, int $depth = 512, int $flags = 0)
    {
        if (isset($this->data) ) {
            return $this->data;
        }

        $this->data = json_decode($this->content, $associative, $depth, $flags);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw HttpException::jsonDecodeFailed(json_last_error(), json_last_error_msg());
        }

        return $this->data;
    }

    /**
     * Get header value.
     *
     * @param  string  $name
     * @return null|string
     */
    public function header(string $name): ?string
    {
        $name = strtolower($name);

        if (! isset($this->headers[$name])) {
            return null;
        }

        $value = $this->headers[$name];

        $semi = strpos($value, ';');

        if ($semi === false) {
            return $value;
        }

        return substr($value, 0, $semi);
    }

    /**
     * Parse header lines with this format: `Header: value`
     *
     * @param  array  $headers
     * @return array
     */
    protected function parseHeaderLines(array $headers): array
    {
        if (is_string(array_keys($headers)[0])) {
            return $headers;
        }

        if (strtolower(substr($headers[0], 0, 5)) == 'http/') {
            array_shift($headers);
        }

        foreach ($headers as $idx => $value) {
            $value = trim($value);

            if (! empty($value)) {
                [$key, $value] = explode(': ', $value, 2);

                $headers[strtolower($key)] = $value;
            }

            unset($headers[$idx]);
        }

        return $headers;
    }
}
