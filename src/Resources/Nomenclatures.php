<?php

namespace MikeyDevelops\Econt\Resources;

use MikeyDevelops\Econt\Models\Collections\ModelCollection;
use MikeyDevelops\Econt\Resources\Resource;

/**
 * Interface with Nomenclatures Service.
 *
 * @see https://ee.econt.com/services/Nomenclatures/#NomenclaturesService
 */
class Nomenclatures extends Resource
{
    /**
     * The base uri for the resource.
     *
     * @var string
     */
    protected string $baseUri = 'Nomenclatures/NomenclaturesService';

    /**
     * All countries where Econt Express operates.
     *
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection
     * @see https://ee.econt.com/services/Nomenclatures/#NomenclaturesService-getCountries
     */
    public function getCountries(): ModelCollection
    {
        return $this->collectionFromResponse(
            $this->call('getCountries'),
            \MikeyDevelops\Econt\Models\Country::class,
            'countries',
        );
    }

    /**
     * Method for requesting the cities in a country.
     *
     * @param  string  $countryCode  Three-letter ISO Alpha-3 code of the country (e.g. AUT, BGR, etc.)
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection
     * @see https://ee.econt.com/services/Nomenclatures/#NomenclaturesService-getCities
     */
    public function getCities(string $countryCode): ModelCollection
    {
        return $this->collectionFromResponse(
            $this->call('getCities', compact('countryCode')),
            \MikeyDevelops\Econt\Models\City::class,
            'cities',
        );
    }

    /**
     * All offices of Econt Express in a country.
     *
     * @param  string  $countryCode  Three-letter ISO Alpha-3 code of the country (e.g. AUT, BGR, etc.)
     * @param  integer|null  $cityID  [optional] ID of a city.
     * @param  boolean|null  $showCargoReceptions  [optional] Show cargo reception offices.
     * @param  boolean|null  $showLC  [optional] Show logistic center offices.
     * @param  boolean|null  $servingReceptions  [optional] Show offices witch serving the city from reception.
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection
     * @see https://ee.econt.com/services/Nomenclatures/#NomenclaturesService-getOffices
     */
    public function getOffices(string $countryCode, ?int $cityID = null, ?bool $showCargoReceptions = null, ?bool $showLC = null, ?bool $servingReceptions = null): ModelCollection
    {
        $params = compact('countryCode', 'cityID', 'showCargoReceptions', 'showLC', 'servingReceptions');
        // remove nulled parameters
        $params = array_filter($params, function ($v) {
            return ! is_null($v);
        });

        return $this->collectionFromResponse(
            $this->call('getOffices', $params),
            \MikeyDevelops\Econt\Models\Office::class,
            'offices'
        );
    }

    /**
     * Requests all streets in a city.
     *
     * @param  integer  $cityID  ID of a city.
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection
     * https://ee.econt.com/services/Nomenclatures/#NomenclaturesService-getStreets
     */
    public function getStreets(int $cityID): ModelCollection
    {
        return $this->collectionFromResponse(
            $this->call('getStreets', compact('cityID')),
            \MikeyDevelops\Econt\Models\Street::class,
            'streets',
        );
    }

    /**
     * Requests all quarters/neighborhoods in a city.
     *
     * @param  integer  $cityID  ID of a city.
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection
     * @see https://ee.econt.com/services/Nomenclatures/#NomenclaturesService-getQuarters
     */
    public function getQuarters(int $cityID): ModelCollection
    {
        return $this->collectionFromResponse(
            $this->call('getQuarters', compact('cityID')),
            \MikeyDevelops\Econt\Models\Quarter::class,
            'quarters',
        );
    }

    /**
     * Alias to getQuarters. Requests all neighborhoods in a city.
     *
     * @param  integer  $cityID  ID of a city.
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection
     * @see \MikeyDevelops\Econt\Resources\Nomenclatures::getQuarters()
     */
    public function getNeighborhoods(int $cityID): ModelCollection
    {
        return $this->getQuarters($cityID);
    }
}
