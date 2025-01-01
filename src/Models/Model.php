<?php

namespace MikeyDevelops\Econt\Models;

use ArrayAccess;
use JsonSerializable;
use MikeyDevelops\Econt\Exceptions\EcontException;
use MikeyDevelops\Econt\Interfaces\NeedsEcont;
use MikeyDevelops\Econt\Resources\Resource;
use MikeyDevelops\Econt\Traits\InteractsWithEcontClient;

class Model implements ArrayAccess, JsonSerializable, NeedsEcont
{
    use InteractsWithEcontClient;

    /**
     * The attributes of the model.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The resource that created this model.
     *
     * @var \MikeyDevelops\Econt\Resources\Resource|null
     */
    protected $resource;

    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * An array of casted properties. Used for cache, so that a property has only one instance.
     *
     * @var array
     */
    protected $casted = [];

    /**
     * Alias for properties.
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Create a new Econt Model Instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function getAttribute(string $key, $default = null)
    {
        $key = $this->resolveAlias($key);

        if ($this->isCastable($key)) {
            return $this->castAttribute($key);
        }

        return $this->getOriginal($key, $default);
    }

    /**
     * Get a new collection instance for the model.
     *
     * @param  array  $models
     * @return \MikeyDevs\Econt\Models\Collections\ModelCollection<static>
     */
    public function newCollection(array $models = [])
    {
        return new Collections\ModelCollection($models);
    }

    /**
     * Create new instance of model.
     *
     * @param  array  $attributes
     * @param  class-string|null  $model Optional to overwrite current model type.
     * @return \MikeyDevelops\Econt\Models\Model
     */
    public function newInstance(array $attributes = [], ?string $model = null)
    {
        $model = $model ?? static::class;

        if (! is_subclass_of($model, Model::class)) {
            $model = Model::class;
        }

        $model = new $model($attributes);

        if ($model instanceof NeedsEcont) {
            $model->setClient($this->getClient());
        }

        return $model;
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param  array  $attributes
     * @param  \MikeyDevelops\Econt\Resources\Resource|null  $resource
     * @return static
     */
    public function newFromResource($attributes = [], ?Resource $resource = null)
    {
        $instance = $this->newInstance($attributes);

        if (! is_null($resource)) {
            $instance->setResource($resource);
        }

        return $instance;
    }

    /**
     * Check to see if an attribute is castable or not.
     *
     * @param  string  $attribute
     * @return boolean
     */
    public function isCastable(string $attribute)
    {
        return isset($this->casts[$this->resolveAlias($attribute)]);
    }

    /**
     * Cast an attribute to the specified type.
     *
     * @param  string  $attribute
     * @return mixed
     */
    public function castAttribute(string $attribute)
    {
        $attribute = $this->resolveAlias($attribute);

        if (isset($this->casted[$attribute])) {
            return $this->casted[$attribute];
        }

        $value = $this->getOriginal($attribute);

        if (is_null($attribute)) {
            return null;
        }

        $type = $this->casts[$attribute] ?? null;

        if (! $type) {
            return $value;
        }

        if (class_exists($type)) {
            return $this->newInstance($value, $type);
        }

        list($type, $params) = explode(':', $type, 2) + [null, []];
        $params = explode(',', $params);

        if ($type == 'array') {
            $value = (array) $value;

            if (isset($params[0]) && class_exists($params[0])) {
                $value = array_map(function ($v) use ($params) {
                    return $this->newInstance($v, $params[0]);
                }, $value);
            }
        }

        return $value;
    }

    /**
     * Get a unmodified attribute from the model.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function getOriginal(string $key, $default = null)
    {
        return $this->attributes[$this->resolveAlias($key)] ?? $default;
    }

    /**
     * Set a model attribute.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return static
     */
    public function setAttribute(string $key, $value)
    {
        $this->attributes[$this->resolveAlias($key)] = $value;

        return $this;
    }

    /**
     * Get the name of the aliased column.
     *
     * @param  string  $alias
     * @return string
     */
    protected function resolveAlias(string $alias): string
    {
        return $this->aliases[$alias] ?? $alias;
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
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return ! is_null($this->getAttribute($offset));
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->getAttribute($offset);
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
        $this->setAttribute($offset, $value);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
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
     * Determine if an attribute or relation exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->getResource()->{$method}(...$parameters);
    }

    /**
     * Handle dynamic static method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
