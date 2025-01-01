<?php

namespace MikeyDevelops\Econt\Resources;

use MikeyDevelops\Econt\Client;
use MikeyDevelops\Econt\Interfaces\NeedsEcont;
use MikeyDevelops\Econt\Models\Collections\ModelCollection;
use MikeyDevelops\Econt\Models\Model;
use MikeyDevelops\Econt\Traits\InteractsWithEcontClient;

class Resource implements NeedsEcont
{
    use InteractsWithEcontClient;

    /**
     * The base uri for the resource.
     *
     * @var string
     */
    protected string $baseUri = '/';

    /**
     * The model type for the resource.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Create a new resource instance.
     *
     * @param  \MikeyDevelops\Econt\Client  $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Call a method.
     *
     * @param  string  $method  The name of the method.
     * @param  array  $params  The parameters.
     * @return array|null
     * @throws \MikeyDevelops\Econt\EcontException
     */
    public function call(string $method, array $params = []): ?array
    {
        return $this->request('POST', "$this->baseUri.$method", $params, false);
    }

    /**
     * Make a request tot the api.
     *
     * @param  mixed  $method
     * @param  mixed  $uri
     * @param  array  $data
     * @param  boolean  $prependBaseUri
     * @return \MikeyDevelops\Econt\Models\Model|null
     */
    public function request(string $method, string $uri, array $data = [], bool $prependBaseUri = true)
    {
        if ($prependBaseUri && substr($uri, 0, 1) != '/') {
            $uri = rtrim($this->baseUri, '/') . '/' . $uri;
        }

        // auto append json for json response.
        if (substr($uri, -5) != '.json') {
            $uri .= '.json';
        }

        return $this->client->request($method, $uri, $data);
    }

    /**
     * Create a new model instance for the resource.
     *
     * @param  array  $attributes
     * @param  class-string|null  $model  Optional model to overwrite the resource model.
     * @return \MikeyDevelops\Econt\Models\Model
     */
    public function newModelInstance(array $attributes = [], ?string $model = null)
    {
        $model = $model ?? $this->model;
        $model = new $model($attributes);

        $model->setResource($this);

        if ($model instanceof NeedsEcont) {
            $model->setClient($this->getClient());
        }

        return $model;
    }

    /**
     * Create a collection for the model.
     *
     * @param  array  $request
     * @param  class-string|null  $model  Optional model to overwrite the resource model.
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection<static>
     */
    public function newModelCollection(array $models = [], ?string $model = null)
    {
        $model = $this->newModelInstance([], $model);

        $collection = $model->newCollection($models);

        if ($collection instanceof NeedsEcont) {
            $collection->setClient($this->getClient());
        }

        return $collection;
    }

    /**
     * Create a collection of models from plain arrays.
     *
     * @template T
     * @param  array  $models
     * @param  class-string<T>|null  $model  Optional model to overwrite the resource model.
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection<T>
     */
    public function hydrate(array $models = [], ?string $model = null)
    {
        $model = $model ?? $this->model;

        return $this->newModelCollection(array_map(function (array $attributes) use ($model) {
            return $model::fromResource($attributes, $this);
        }, $models), $model);
    }
}