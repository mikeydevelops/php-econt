<?php

namespace MikeyDevelops\Econt\Models;

/**
 * City served by Econt Express. Required fields for valid city - ID or name + post code
 * (if the City is outside Bulgaria, country is required)
 *
 * @property  integer  $id  The country identifier.
 * @property-read  \MikeyDevelops\Econt\Models\Country  $country  The country where the city is located.
 * @property  string  $postCode  The postal code.
 * @property  string  $name  The name of the city in Bulgarian.
 * @property  string  $nameEn  The name of the city in English.
 * @property  string  $regionName  The name of the city region in Bulgarian.
 * @property  string  $regionNameEn  The name of the city region in English.
 * @property  string  $phoneCode  The phone prefix for the city.
 * @property-read  \MikeyDevelops\Econt\Models\GeoLocation  $location  Geo location.
 * @property  boolean  $expressCityDeliveries  Indicates if express city deliveries are available.
 * @property  boolean  $monday  Indicates if the city is serviced on Monday.
 * @property  boolean  $tuesday  Indicates if the city is serviced on Tuesday.
 * @property  boolean  $wednesday  Indicates if the city is serviced on Wednesday.
 * @property  boolean  $thursday  Indicates if the city is serviced on Thursday.
 * @property  boolean  $friday  Indicates if the city is serviced on Friday.
 * @property  boolean  $saturday  Indicates if the city is serviced on Saturday.
 * @property  boolean  $sunday  Indicates if the city is serviced on Sunday.
 * @property  integer  $serviceDays  Number of days needed to deliver to this city.
 * @property  integer  $zoneId  Id of the zone in which the city is located.
 * @property  string  $zoneName Bulgarian name of the zone in which the city is located.
 * @property  string  $zoneNameEn International name of the zone in which the city is located.
 * @property-read  \MikeyDevelops\Econt\Models\OfficeService[]  $servingOffices  Offices and types of shipments they serve in the city.
 *
 * @see https://ee.econt.com/services/Nomenclatures/#City
 */
class City extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'country' => Country::class,
        'location' => GeoLocation::class,
        'servingOffices' => 'collection:'.OfficeService::class,
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
}
