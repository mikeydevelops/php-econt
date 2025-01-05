<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Enums\ServiceType;

/**
 * @property  string  $officeCode  Office code.
 * @property-read  \MikeyDevelops\Econt\Enums\ServiceType  $servingType  Service type.
 */
class OfficeService extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'servingType' => 'enum:'.ServiceType::class,
    ];
}
