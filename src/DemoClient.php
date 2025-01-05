<?php

namespace MikeyDevelops\Econt;

use MikeyDevelops\Econt\Client;
use MikeyDevelops\Econt\Interfaces\HttpClient;

class DemoClient extends Client
{
    /**
     * Create new instance of Demo Client.
     *
     * @param  string  $username  The username in ee.econt.com
     * @param  string  $password  The password.
     * @param  boolean  $demo  Make requests to the demo url instead of production.
     * @param  \MikeyDevelops\Econt\Interfaces\HttpClient|null  $client  The http client to use to make requests.
     * @return void
     */
    public function __construct(?string $username = null, ?string $password = null, ?HttpClient $client = null)
    {
        if (! isset($username) || !isset($password)) {
            $username = 'iasp-dev';
            $password = '1Asp-dev';
        }

        parent::__construct($username, $password, true, $client);
    }
}
