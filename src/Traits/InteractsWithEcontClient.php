<?php

namespace MikeyDevelops\Econt\Traits;

use MikeyDevelops\Econt\Client;

trait InteractsWithEcontClient
{
    /**
     * The Econt API client.
     *
     * @var \MikeyDevelops\Econt\Client
     */
    protected ?Client $client = null;

    /**
     * Set the Econt API client for the model.
     *
     * @param  \MikeyDevelops\Econt\Client  $client
     * @return static
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get the Econt API client the model was made from.
     *
     * @return \MikeyDevelops\Econt\Client|null
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }
}
