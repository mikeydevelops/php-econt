<?php

namespace MikeyDevelops\Econt\Exceptions;

use MikeyDevelops\Econt\Exceptions\HttpException;
use MikeyDevelops\Econt\Http\Response;

class RequestFailedException extends HttpException
{
    /**
     * The response related to this exception instance.
     *
     * @var \MikeyDevelops\Econt\Http\Response|null
     */
    protected ?Response $response = null;

    /**
     * Get the related response.
     *
     * @return \MikeyDevelops\Econt\Http\Response|null
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * Set the response.
     *
     * @param  \MikeyDevelops\Econt\Http\Response  $response
     * @return static
     */
    public function setResponse(Response $response): self
    {
        $this->response = $response;

        return $this;
    }
}
