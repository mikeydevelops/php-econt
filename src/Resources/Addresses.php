<?php

namespace MikeyDevelops\Econt\Resources;

use InvalidArgumentException;
use MikeyDevelops\Econt\Enums\ShipmentType;
use MikeyDevelops\Econt\Models\Address;
use MikeyDevelops\Econt\Models\City;
use MikeyDevelops\Econt\Models\ServiceTimes;
use MikeyDevelops\Econt\Models\Collections\ModelCollection;
use MikeyDevelops\Econt\Resources\Resource;

/**
 * Interface with Addresses Service.
 *
 * @see https://ee.econt.com/services/Nomenclatures/#AddressService
 */
class Addresses extends Resource
{
    /**
     * The base uri for the resource.
     *
     * @var string
     */
    protected string $baseUri = 'Nomenclatures/AddressService';

    /**
     * The model type for the resource.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Validate given address.
     * At least street name and street number or quarter and other properties are required to validate an address.
     *
     * Example 1: validateAddress('Русе', 'Славянска', '16');
     * Example 2: validateAddress(\MikeyDevelops\Econt\Models\Address $address);
     *
     * @param  \MikeyDevelops\Econt\Models\Address|string  $cityOrAddress  The name of the city or an address object.
     * @param  string|null  $street  [optional]  The street name.
     * @param  string|null  $num  [optional]  The street number.
     * @param  string|null  $quarter  [optional]  The quarter/neighborhood name.
     * @param  string|null  $other  [optional]  The additional information, like block number, entrance number, floor, apartment number, about the address.
     * @return \MikeyDevelops\Econt\Models\Address  The validated address with additional information about it and a new property $validationStatus.
     * @throws \MikeyDevelops\Econt\Exceptions\EcontException  If required fields are not provided correctly.
     * @see https://ee.econt.com/services/Nomenclatures/#AddressService-validateAddress
     */
    public function validateAddress($cityOrAddress, ?string $street = null, ?string $num = null, ?string $quarter = null, ?string $other = null): Address
    {
        // copy the address if cityOrAddress is of type Address,
        // otherwise construct a new instance with given parameters.
        $address = new Address($cityOrAddress instanceof Address ? $cityOrAddress->toArray() : [
            'city' => [
                'name' => $cityOrAddress,
            ],
        ]);

        $params = array_filter(compact('street', 'num', 'quarter', 'other'));

        $address->fill($params);

        $hasStreet = ! is_null($address->street) && ! is_null($address->num);
        $hasQuarter = ! is_null($address->quarter) && ! is_null($address->other);

        if (! $hasStreet && ! $hasQuarter) {
            $provided = array_keys($params);
            $provided = implode(', ', $provided);
            $provided = strlen($provided) ? "Only $provided provided." : 'None provided.';

            throw new InvalidArgumentException(sprintf(
                '%s::validateAddress requires an address that has at the attributes `street` and `num` or `quarter` and `other`. %s',
                static::class,
                $provided
            ));
        }

        $response = $this->call('validateAddress', compact('address'))->json();
        $address->fill($response['address']);
        $address->validationStatus = $response['validationStatus'];

        return $address;
    }

    /**
     * Validate street and number.
     *
     * @param  \MikeyDevelops\Econt\Models\City|string  $city
     * @param  string  $street  The name of the street.
     * @param  string  $num  The number of the building on the street.
     * @return \MikeyDevelops\Econt\Models\Address
     * @throws \MikeyDevelops\Econt\Exceptions\EcontException
     * @see \MikeyDevelops\Econt\Resources\Addresses::validateAddress()
     */
    public function validateStreet($city, string $street, string $num): Address
    {
        return $this->validateAddress($city instanceof City ? $city->name : $city, $street, $num);
    }

    /**
     * Validate a quarter/neighborhood address.
     *
     * @param  \MikeyDevelops\Econt\Models\City|string  $city
     * @param  string  $quarter  The name of the quarter/neighborhood.
     * @param  string  $other  The additional information about the address.
     * @return \MikeyDevelops\Econt\Models\Address
     * @throws \MikeyDevelops\Econt\Exceptions\EcontException
     * @see \MikeyDevelops\Econt\Resources\Addresses::validateAddress()
     */
    public function validateQuarter($city, string $quarter, string $other): Address
    {
        return $this->validateAddress($city instanceof City ? $city->name : $city, null, null, $quarter, $other);
    }

    /**
     * Validate a neighborhood address.
     * Alias of validateQuarter().
     *
     * @param  \MikeyDevelops\Econt\Models\City|string  $city
     * @param  string  $neighborhood  The name of the neighborhood.
     * @param  string  $other  The additional information about the address.
     * @return \MikeyDevelops\Econt\Models\Address
     * @throws \MikeyDevelops\Econt\Exceptions\EcontException
     * @see \MikeyDevelops\Econt\Resources\Addresses::validateQuarter()
     */
    public function validateNeighborhood($city, string $neighborhood, string $other): Address
    {
        return $this->validateQuarter($city instanceof City ? $city->name : $city, $neighborhood, $other);
    }

    /**
     * Geo locates an address and provides service times for that address.
     *
     * @param  integer  $cityId  ID of the city.
     * @param  string  $address  Address to check for servicing.
     * @param  string  $date  The date for which to check servicing.
     * @param  \MikeyDevelops\Econt\Enums\ShipmentType  $shipmentType  The type of shipment to check.
     * @return \MikeyDevelops\Econt\Models\ServiceTimes
     *
     * @see https://ee.econt.com/services/Nomenclatures/#AddressService-addressServiceTimes
     */
    public function addressServiceTimes(int $cityId, string $address, string $date, ShipmentType $shipmentType): ServiceTimes
    {
        $response = $this->call('addressServiceTimes', [
            'city' => $cityId,
            'address' => $address,
            'date' => $date,
            'shipmentType' => $shipmentType->value,
        ]);

        return $this->newModelInstance($response->json(), ServiceTimes::class);
    }

    /**
     * Information service for offices near given address.
     *
     * @param  \MikeyDevelops\Econt\Models\Address  $address  The address.
     * @param  \MikeyDevelops\Econt\Enums\ShipmentType|null  $shipmentType  [optional] Filter offices that service this shipment type.
     * @return  \MikeyDevelops\Econt\Models\Office[]|\MikeyDevelops\Econt\Models\Collections\ModelCollection<\MikeyDevelops\Econt\Models\Office> The resulting offices.
     * @see https://ee.econt.com/services/Nomenclatures/#AddressService-getNearestOffices
     */
    public function getNearestOffices(Address $address, ?ShipmentType $shipmentType = null): ModelCollection
    {
        return $this->collectionFromResponse(
            $this->call('getNearestOffices', compact('address', 'shipmentType')),
            \MikeyDevelops\Econt\Models\Office::class,
            'offices',
        );
    }
}
