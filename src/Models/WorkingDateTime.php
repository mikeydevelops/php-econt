<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Enums\DayType;

/**
 * Working date and hours span.
 *
 * @property-read  \MikeyDevelops\Econt\Enums\DayType $dayType  The type of day.
 * @property  string  $day  The date.
 * @property  string  $start  The starting hours of the period.
 * @property  string  $end  The ending hours of the period.
 *
 * @see https://ee.econt.com/services/Nomenclatures/#WorkingDateTime
 */
class WorkingDateTime extends Model
{

    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'dayType' => 'enum:'.DayType::class,
    ];
}
