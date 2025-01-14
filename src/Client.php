<?php

namespace MikeyDevelops\Econt;

use MikeyDevelops\Econt\Interfaces\HttpClient;
use MikeyDevelops\Econt\Exceptions\EcontException;
use MikeyDevelops\Econt\Exceptions\EcontHttpException;
use MikeyDevelops\Econt\Exceptions\RequestFailedException;
use MikeyDevelops\Econt\Http\CurlClient;
use MikeyDevelops\Econt\Http\Response;
use MikeyDevelops\Econt\Resources\Resource;

/**
 * @property-read  \MikeyDevelops\Econt\Resources\Profiles  $profiles  The profiles service.
 * @property-read  \MikeyDevelops\Econt\Resources\Shipments  $shipments  The Shipments service.
 * @property-read  \MikeyDevelops\Econt\Resources\Labels  $labels  The labels service.
 * @property-read  \MikeyDevelops\Econt\Resources\Nomenclatures  $nomenclatures  The nomenclatures service.
 * @property-read  \MikeyDevelops\Econt\Resources\Nomenclatures  $locations  The locations service. Aliased from Nomenclatures.
 * @property-read  \MikeyDevelops\Econt\Resources\Addresses  $addresses  The addresses service.
 * @property-read  \MikeyDevelops\Econt\Resources\ThreeWay  $threeWay  The three way logistics service.
 * @property-read  \MikeyDevelops\Econt\Resources\PaymentReports  $paymentReports  The payment reports service.
 */
class Client
{
    /**
     * The url to the production version of e-econt.
     */
    const LIVE_URL = 'https://ee.econt.com/services';

    /**
     * The url to the demo version of e-econt.
     */
    const DEMO_URL = 'https://demo.econt.com/ee/services';

    /**
     * The HTTP client to make requests with.
     */
    protected ?HttpClient $http = null;

    /**
     * Determines if the client is in demo mode.
     */
    protected bool $demo = false;

    /**
     * The basic authentication for the API. format: "$username:$password".
     * If set it will be automatically added to every request.
     *
     * @var string|null
     */
    private ?string $auth = null;

    /**
     * List of available resources this client can spawn.
     *
     * @var array<string,class-string>
     */
    public static $availableResources = [
        'profiles' => \MikeyDevelops\Econt\Resources\Profiles::class,
        'shipments' => \MikeyDevelops\Econt\Resources\Shipments::class,
        'labels' => \MikeyDevelops\Econt\Resources\Labels::class,
        'nomenclatures' => \MikeyDevelops\Econt\Resources\Nomenclatures::class,
        'locations' => \MikeyDevelops\Econt\Resources\Nomenclatures::class,
        'addresses' => \MikeyDevelops\Econt\Resources\Addresses::class,
        'threeWay' => \MikeyDevelops\Econt\Resources\ThreeWay::class,
        'paymentReports' => \MikeyDevelops\Econt\Resources\PaymentReports::class,
    ];

    /**
     * The already spawned resources.
     *
     * @var array<string,\MikeyDevelops\Econt\Resources\Resource>
     */
    protected $resources = [];

    /**
     * Create new instance of Client.
     *
     * @param  string  $username  The username in ee.econt.com
     * @param  string  $password  The password.
     * @param  boolean  $demo  Make requests to the demo url instead of production.
     * @param  \MikeyDevelops\Econt\Interfaces\HttpClient|null  $client  The http client to use to make requests.
     * @return void
     */
    public function __construct(string $username, string $password, bool $demo = false, ?HttpClient $client = null)
    {
        $this->auth = "$username:$password";
        $this->demo = $demo;
        $this->http = $client ?? (new CurlClient())
            ->setBaseUrl($this->demo ? static::DEMO_URL : static::LIVE_URL);
    }

    /**
     * Handle dynamic method calls into the api instance.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $data
     * @return \MikeyDevelops\Econt\Http\Response
     */
    public function request(string $method, string $uri, array $data = []): Response
    {
        if (in_array(strtolower($method), ['GET', 'HEAD'])) {
            $data = [ 'query' => $data, ];
        } else {
            $data = [ 'json' => $data, ];
        }

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->auth),
        ];

        try {
            $response = $this->http->request($method, $uri, $data, $headers);
        } catch (RequestFailedException $ex) {
            throw EcontHttpException::fromHttpClient($ex);
        }

        return $response;
    }

    /**
     * Check to see if specified resource is valid.
     *
     * @param  string  $resource
     * @return boolean
     */
    public function isValidResource(string $resource)
    {
        if (class_exists($resource) && is_subclass_of($resource, Resource::class) && in_array($resource, static::$availableResources)) {
            return true;
        }

        if (isset(static::$availableResources[$resource])) {
            return true;
        }

        return false;
    }

    /**
     * Get or create instance of a resource.
     *
     * @param  class-string  $resource
     * @param  boolean  $forceCreate
     * @return \MikeyDevelops\Econt\Resources\Resource
     * @throws \MikeyDevelops\Econt\Exceptions\EcontException
     */
    public function makeResource(string $resource, bool $forceCreate = false)
    {
        $original = $resource;

        if (isset($this->resources[$original]) && ! $forceCreate) {
            return $this->resources[$original];
        }

        $alias = null;

        if (isset(static::$availableResources[$resource])) {
            $alias = $resource;
            $resource = static::$availableResources[$alias];
        }

        if (!class_exists($resource) || !is_subclass_of($resource, Resource::class) || !in_array($resource, static::$availableResources)) {
            throw EcontException::invalidResource($resource);
        }

        /** @var \MikeyDevelops\Econt\Resources\Resource $resource */
        $resource = new $resource($this);

        $this->resources[$original] = $resource;

        return $resource;
    }

    /**
     * Set the correct base url depending if client is in live or demo mode.
     *
     * @return static
     */
    protected function syncBaseUrl(): self
    {
        $this->http->setBaseUrl($this->demo ? static::DEMO_URL : static::LIVE_URL);

        return $this;
    }

    /**
     * Change the client mode to demo if $value true.
     *
     * @param  boolean  $value
     * @return static
     */
    public function demo(bool $value = true): self
    {
        $this->demo = $value;

        return $this->syncBaseUrl();
    }

    /**
     * Change the client mode to live if $value true.
     *
     * @param  boolean  $value
     * @return static
     */
    public function live(bool $value = true): self
    {
        $this->demo = ! $value;

        return $this->syncBaseUrl();
    }

    /**
     * Check to see if the client is in demo mode.
     *
     * @return boolean
     */
    public function isDemo(): bool
    {
        return $this->demo;
    }

    /**
     * Check to see if the client is in live mode.
     *
     * @return boolean
     */
    public function isLive(): bool
    {
        return ! $this->demo;
    }

    /**
     * Handle dynamic property accessing.
     *
     * @param  string  $name
     * @return \MikeyDevelops\Econt\Resources\Resource|null
     */
    public function __get(string $name)
    {
        if ($this->isValidResource($name)) {
            return $this->makeResource($name);
        }

        throw EcontException::invalidResource($name);
    }
}
