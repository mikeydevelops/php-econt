<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Resources\Resource;

/**
 * Address. Required fields for valid address - city, street and street number (or quarter and other).
 * Use respective fields or all joined together in the field $fullAddress
 *
 * @property  integer  $id  The address identifier.
 * @property-read  \MikeyDevelops\Econt\Models\City  $city  The city where the address is located.
 * @property  string  $fullAddress  The whole address.
 * @property  string  $fullAddressEn  The whole address in English.
 * @property  string  $quarter  Quarter (Neighborhood) name.
 * @property  string  $street  The street name.
 * @property  string  $num  The street number.
 * @property  string  $other  Block number, entrance number, floor, apartment number and other additional information.
 * @property  \MikeyDevelops\Econt\Models\GeoLocation  $location  Geo coordinates.
 * @property  string  $zip  ZIP code.
 * @property  string  $hezid
 * @property  string  $validationStatus  The validation status of the address. 'normal', 'processed', 'invalid'.
 *                                       Populated from \MikeyDevelops\Econt\Resources\Addresses::validateAddress()
 *
 * Aliases
 * @property  string  $neighborhood  Alias for $quarter. The name of the neighborhood.
 *
 * @see https://ee.econt.com/services/Nomenclatures/#Address
 */
class Address extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'city' => City::class,
        'location' => GeoLocation::class,
    ];

    /**
     * Alias for properties.
     * Keys of the array are the alias and the values are the name of the property that is aliased.
     *
     * @var array
     */
    protected $aliases = [
        'neighborhood' => 'quarter',
    ];

    /**
     * Create a new model instance that is existing.
     * Automatically set validation status to normal since a resource is creating this model.
     *
     * @param  array  $attributes
     * @param  \MikeyDevelops\Econt\Resources\Resource|null  $resource
     * @return static
     */
    public function newFromResource($attributes = [], ?Resource $resource = null)
    {
        $instance = parent::newFromResource($attributes, $resource);

        $instance->validationStatus = 'normal';

        return $instance;
    }

    /**
     * Check to see if the address is valid.
     *
     * @return boolean
     */
    public function isValid(): bool
    {
        return !is_null($this->validationStatus) && $this->validationStatus != 'invalid';
    }

    /**
     * Validate this address.
     *
     * @param  boolean  $merge  Merge the validation result from econt api with this object.
     * @return boolean
     * @throws \MikeyDevelops\Econt\Exceptions\EcontException
     */
    public function validate(bool $merge = true): bool
    {
        $address = $this->client->addresses->validateAddress($this);

        $this->validationStatus = $address->validationStatus;

        if ($merge) {
            $this->fill($address->toArray());
        }

        return $this->isValid();
    }
}
