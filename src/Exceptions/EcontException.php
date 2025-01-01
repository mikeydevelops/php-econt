<?php

namespace MikeyDevelops\Econt\Exceptions;

use RuntimeException;
use Throwable;
use MikeyDevelops\Econt\Client;

class EcontException extends RuntimeException
{
    /**
     * Create a new instance of Econt Exception.
     *
     * @param  string  $message
     * @param  integer  $code
     * @param  \Throwable|null  $previous
     * @return void
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }

    /**
     * Exception when a resource was tried to be made, but it was not found.
     *
     * @param  string  $resource
     * @return static
     */
    public static function invalidResource(string $resource)
    {
        return new static(sprintf(
                'Tried to make invalid resource [%s]. Available: %s.',
                $resource, implode(', ', array_keys(Client::$availableResources)
            )),
            422
        );
    }

    /**
     * Create a new JSON encoding exception for the model.
     *
     * @param  mixed  $model
     * @param  string  $message
     * @return static
     */
    public static function jsonEncoding($model, $message)
    {
        return new static('Error encoding econt model ['.get_class($model).'] to JSON: '.$message);
    }
}
