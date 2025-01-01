<?php

namespace MikeyDevelops\Econt\Models\Collections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Iterator;
use JsonSerializable;
use MikeyDevelops\Econt\Exceptions\EcontException;
use MikeyDevelops\Econt\Interfaces\NeedsEcont;
use MikeyDevelops\Econt\Resources\Resource;
use MikeyDevelops\Econt\Traits\InteractsWithEcontClient;

class ModelCollection implements ArrayAccess, Countable, JsonSerializable, Iterator, NeedsEcont
{
    use InteractsWithEcontClient;

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
    protected Resource $resource;

    /**
     * The current index of the iterator.
     *
     * @var integer
     */
    protected int $index = 0;

    /**
     * Create a new Model collection instance.
     *
     * @param  \MikeyDevelops\Econt\Models\Model[]  $models
     * @return void
     */
    public function __construct(array $models)
    {
        $this->models = $models;
    }

    /**
     * Get all the models from the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->models;
    }

    /**
     * Set the resource for the model.
     *
     * @param  \MikeyDevelops\Econt\Resources\Resource  $resource
     * @return static
     */
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get the resource the model was made from.
     *
     * @return \MikeyDevelops\Econt\Resources\Resource|null
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Create new instance of Model Collection from response from API.
     *
     * @param  array  $response
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection
     * @throws \MikeyDevelops\Econt\Exceptions\EcontException
     */
    public function fromResponse(array $response): self
    {
        throw new EcontException(sprintf(
            "%s::fromResponse is not implemented. It is intended to be implemented by children of %s.",
            static::class,
            ModelCollection::class,
        ));
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
