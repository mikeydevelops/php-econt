<?php

namespace MikeyDevelops\Econt\Exceptions;

use MikeyDevelops\Econt\Exceptions\EcontException;
use MikeyDevelops\Econt\Exceptions\RequestFailedException;

class EcontHttpException extends EcontException
{
    /**
     * Create a Econt Http Exception from Guzzle exception.
     *
     * @param  \MikeyDevelops\Econt\Exceptions\RequestFailedException  $exception
     * @return static
     */
    public static function fromHttpClient(RequestFailedException $exception)
    {
        return new static(
            $exception->getMessage(),
            $exception->getResponse()->status(),
            $exception
        );
    }
}
