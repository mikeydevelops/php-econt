<?php

namespace MikeyDevelops\Econt\Interfaces;

use MikeyDevelops\Econt\Client;

interface NeedsEcont
{
    /**
     * Set the Econt API client for the model.
     *
     * @param  \MikeyDevelops\Econt\Client  $client
     * @return static
     */
    public function setClient(Client $client): self;

    /**
     * Get the Econt API client the model was made from.
     *
     * @return \MikeyDevelops\Econt\Client|null
     */
    public function getClient(): ?Client;
}
