<?php

namespace MikeyDevelops\Econt\Models\Collections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Iterator;
use JsonSerializable;
use MikeyDevelops\Econt\Exceptions\EcontException;
use MikeyDevelops\Econt\Http\Response;
use MikeyDevelops\Econt\Interfaces\NeedsEcont;
use MikeyDevelops\Econt\Resources\Resource;
use MikeyDevelops\Econt\Traits\InteractsWithEcontClient;

class ModelCollection implements ArrayAccess, Countable, JsonSerializable, Iterator, NeedsEcont
{
    use InteractsWithEcontClient;

    /**
     * The model type in this collection.
     *
     * @var string|null
     */
    protected ?string $modelType = null;

    /**
     * The models for the collection.
     *
     * @var array
     */
    protected array $models = [];

    /**
     * The resource that created this model.
     *
     * @var \MikeyDevelops\Econt\Resources\Resource|null
     */
    protected ?Resource $resource = null;

    /**
     * The related response.
     *
     * @var \MikeyDevelops\Econt\Http\Response|null
     */
    protected ?Response $response = null;

    /**
     * The current index of the iterator.
     *
     * @var integer
     */
    protected int $index = 0;

    /**
     * Create a new Model collection instance.
     *
     * @param  \MikeyDevelops\Econt\Models\Model[]|array[]  $models
     * @param  class-string  $modelType  Optional the type of the model.
     * @return void
     */
    public function __construct(array $models, ?string $modelType = null)
    {
        $this->models = $models;

        $this->modelType = $modelType ?? $models ? get_class(reset($models)) : null;
    }

    /**
     * Get all the models from the collection.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->models;
    }

    /**
     * Get the resource the model was made from.
     *
     * @return \MikeyDevelops\Econt\Resources\Resource|null
     */
    public function resource(): ?Resource
    {
        return $this->resource;
    }

    /**
     * Set the resource for the collection.
     *
     * @param  \MikeyDevelops\Econt\Resources\Resource  $resource
     * @return static
     */
    public function setResource(Resource $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Create new instance of Model Collection from response from API.
     *
     * @param  \MikeyDevelops\Econt\Http\Response  $response  The response.
     * @param  class-string  $modelType  The type of the model in the request data.
     * @param  string|null  $key  [optional] Key to access the array of models in the response data.
     * @return static
     * @throws \MikeyDevelops\Econt\Exceptions\EcontException
     */
    public static function fromResponse(Response $response, string $modelType, ?string $key = null): self
    {
        $models = $response->json();

        if (! is_null($key)) {
            $models = $models[$key];
        }

        $collection = (new static($models, $modelType))
            ->setResponse($response);

        return $collection;
    }

    /**
     * Get the related request.
     *
     * @return \MikeyDevelops\Econt\Http\Response|null
     */
    public function response(): ?Response
    {
        return $this->response;
    }

    /**
     * Set the related response.
     *
     * @param  \MikeyDevelops\Econt\Http\Response  $response
     * @return static
     */
    public function setResponse(Response $response): self
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($model) {
            return is_object($model) && method_exists($model, 'toArray') ? $model->toArray() : $model;
        }, $this->models);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->models[$offset]);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->models[$offset];
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->models[$offset] = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->models[$offset]);
    }

    /**
    * Convert the model instance to JSON.
    *
    * @param  int  $options
    * @return string
    */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw EcontException::jsonEncoding($this, json_last_error_msg());
        }

        return $json;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Count the number of models in the collection.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->models);
    }

    /**
     * Get an iterator for the models.
     *
     * @return \ArrayIterator
     */
    public function getIterator(): Iterator
    {
        return $this;
    }

    /**
     * Get the current model of the collection.
     *
     * @return \MikeyDevelops\Econt\Models\Model
     */
    public function current(): mixed
    {
        return $this->offsetGet($this->index);
    }

    /**
     * Get the index of the current model in the collection.
     *
     * @return integer
     */
    public function key(): int
    {
        return $this->index;
    }

    /**
     * Advance the iterator to the next model index in the collection.
     *
     * @return static
     */
    public function next(): void
    {
        ++$this->index;
    }

    /**
     * Revert the iterator to the start of the collection.
     *
     * @return static
     */
    public function rewind(): void
    {
        $this->index = 0;
    }

    /**
     * Check to see if the index is valid for the iterator.
     *
     * @return boolean
     */
    public function valid(): bool
    {
        return $this->offsetExists($this->index);
    }
}
