<?php

namespace MikeyDevelops\Econt\Exceptions;

use Throwable;
use MikeyDevelops\Econt\Exceptions\EcontException;

class HttpException extends EcontException
{
    /**
     * Prepare new Http Exception for unsupported method.
     *
     * @param  string  $method  The method that is unsupported.
     * @param  array  $supported  List of supported methods.
     * @param  \Throwable|null  $previous
     * @return static
     */
    public static function unsupportedMethod(string $method, array $supported = [], Throwable $previous = null): self
    {
        $message = "Unsupported HTTP request method [$method].";

        if (! empty($supported)) {
            $message .= ' Supported: ' . implode(', ', $supported);
        }

        return new static($message, 0, $previous);
    }

    /**
     * Prepare new Http Exception when json_encode fails.
     *
     * @param  string  $errno  The json encode error code.
     * @param  string|null  $errmsg  The json encode error message.
     * @param  \Throwable|null  $previous
     * @return static
     */
    public static function jsonEncodeFailed(int $errno, ?string $errmsg = null, ?Throwable $previous = null): self
    {
        return new static($errmsg ?? 'json_encode unknown error', $errno, $previous);
    }

    /**
     * Prepare new Http Exception when json_decode fails.
     *
     * @param  string  $errno  The json encode error code.
     * @param  string|null  $errmsg  The json encode error message.
     * @param  \Throwable|null  $previous
     * @return static
     */
    public static function jsonDecodeFailed(int $errno, ?string $errmsg = null, ?Throwable $previous = null): self
    {
        return new static($errmsg ?? 'json_decode unknown error', $errno, $previous);
    }
}
