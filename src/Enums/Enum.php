<?php

namespace  MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Exceptions\EnumException;
use ReflectionClass;

/**
 * @property-read  string  $name  The name of the enum case.
 * @property-read  string|integer  $value  The value of the enum case.
 */
abstract class Enum
{
    /**
     * The name of the value current value of the enum, the constant name.
     *
     * @var string
     */
    private $key;

    /**
     * The value of the current value of the enum, the value of the constant.
     *
     * @var string|integer
     */
    private $current;

    /**
     * The constant cache of each enum.
     *
     * @var array<class-string,array<string,string|integer>>
     */
    private static $constants = [];

    /**
     * The unique instances of each case for the enum.
     *
     * @var array<class-string,array<string,static>>
     */
    private static $instances = [];

    /**
     * Create new instance of Enum.
     *
     * @param  static|integer|string  $value  The value of the enum instance.
     */
    public function __construct($value)
    {
        $key = null;

        if ($value instanceof static) {
            $key = $value->name;
            $value = $value->value;
        }

        $this->key = $key ?? static::find($value);
        $this->current = $value;
    }

    /**
     * Get the cases of the enum.
     *
     * @return static[]
     */
    public static function cases(): array
    {
        return array_map(static::class.'::from', static::constants());
    }

    /**
     * Find the key of the given value.
     *
     * @param  string|integer  $value
     * @return string|false
     */
    public static function find($value)
    {
        return array_search($value, static::constants());
    }

    /**
     * Get the instance of the case value.
     *
     * @param  string|integer  $value
     * @return static
     */
    public static function from($value): self
    {
        return static::instance(static::find($value));
    }

    /**
     * Get the constants of the current class.
     *
     * @param  string|null  $key  if provided the value of the case will be returned.
     * @return array|string|integer Depending if key provided it will return the value of the case, otherwise the whole array of cases.
     */
    private static function constants(?string $key = null)
    {
        if (! isset(static::$constants[static::class])) {
            static::$constants[static::class] = (new ReflectionClass(static::class))->getConstants();
        }

        return is_null($key)
            ? static::$constants[static::class]
            : static::$constants[static::class][$key];
    }

    /**
     * Get an instance for given case key of the enum.
     *
     * @param  string  $key
     * @return static
     */
    private static function instance(string $key): self
    {
        if (! isset(static::$instances[static::class][$key])) {
            return static::$instances[static::class][$key] = new static(static::constants($key));
        }

        return static::$instances[static::class][$key];
    }

    /**
     * Allow for $name and $value properties.
     *
     * @param  string  $attribute
     * @return string|int
     * @throws \MikeyDevelops\Econt\Exceptions\EnumException  When tried to access undefined property.
     */
    public function __get(string $attribute)
    {
        if ($attribute == 'name') {
            return $this->key;
        }

        if ($attribute == 'value') {
            return $this->current;
        }

        throw new EnumException(sprintf('Tried to access undefined property %s::$%s.', static::class, $attribute));
    }

    /**
     * Get the correct instance of the enum based on the class and case name.
     *
     * @param  string  $name
     * @param  array  $arguments
     * @return static
     */
    public static function __callStatic($name, $arguments)
    {
        return static::instance($name);
    }
}
