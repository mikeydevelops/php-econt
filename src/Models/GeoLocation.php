<?php

namespace MikeyDevelops\Econt\Models;

/**
 * A geographic location.
 *
 * @property  float  $latitude  Geographic coordinate that specifies the north–south position of a point on the Earth's surface.
 * @property  float  $longitude  Geographic coordinate that specifies the east-west position of a point on the Earth's surface.
 * @property  integer  $confidence The expected accuracy of the location: 0-none, there are either no coordinates or the coordinates do not represent the location; 1-low; 2-medium; 3-high;
 *
 * @see https://ee.econt.com/services/Nomenclatures/#GeoLocation
 */
class GeoLocation extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'confidence' => 'integer',
    ];
}
