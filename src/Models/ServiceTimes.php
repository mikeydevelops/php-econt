<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Models\Model;

/**
 * The result of geo located address.
 *
 * Only aliased properties are documented to remove the prefix 'serviceOffice' because all properties have it.
 * Original properties can also be accessed and will be automatically casted, they are just not documented.
 *
 * @property-read  \MikeyDevelops\Econt\Models\Office  $office  The closest office to address.
 * @property-read  float  $latitude  Service office geo location latitude.
 * @property-read  float  $longitude  Service office geo location longitude.
 * @property-read  \MikeyDevelops\Econt\Models\WorkingTime[]  $clientsWorkTimes  List of time spans available for working with clients.
 * @property-read  \MikeyDevelops\Econt\Models\WorkingTime[]  $courierWorkTimes  List of time spans available for courier request.
 * @property-read  \MikeyDevelops\Econt\Models\WorkingDateTime|null  $time  Service time for the requested date.
 * @property-read  \MikeyDevelops\Econt\Models\WorkingDateTime[]  $next30daysWorkTime  List of working times for future dates.
 *
 * @see MikeyDevelops\Econt\Resources\Addresses::addressServiceTimes()
 * @see https://ee.econt.com/services/Nomenclatures/#AddressService-addressServiceTimes
 */
class ServiceTimes extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'serviceOffice' => Office::class,
        'serviceOfficeLatitude' => 'float',
        'serviceOfficeLongitude' => 'float',
        'serviceOfficeClientsWorkTimes' => 'collection:'.WorkingTime::class,
        'serviceOfficeCourierWorkTimes' => 'collection:'.WorkingTime::class,
        'serviceOfficeTime' => WorkingDateTime::class,
        'serviceOfficeNext30daysWorkTime' => 'collection:'.WorkingDateTime::class,
    ];

    /**
     * Alias for properties.
     * Keys of the array are the alias and the values are the name of the property that is aliased.
     *
     * @var array
     */
    protected $aliases = [
        'office' => 'serviceOffice',
        'latitude' => 'serviceOfficeLatitude',
        'longitude' => 'serviceOfficeLongitude',
        'clientsWorkTimes' => 'serviceOfficeClientsWorkTimes',
        'courierWorkTimes' => 'serviceOfficeCourierWorkTimes',
        'time' => 'serviceOfficeTime',
        'next30daysWorkTime' => 'serviceOfficeNext30daysWorkTime',
    ];
}
