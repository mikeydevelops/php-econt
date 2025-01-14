<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Models\Model;

/**
 * Status of a courier request.
 *
 * @property  integer  $id  The id of the courier request.
 * @property-read  \MikeyDevelops\Econt\Enums\RequestCourierStatusType  $status  The status of the request.
 * @property  string|null  $note  Remarks (Additional information by courier).
 * @property  string|null  $rejectReason  The reason the request was rejected.
 * @property  \MikeyDevelops\Econt\Models\Error|null  $error  The error if it occurred.
 *
 * @package MikeyDevelops\Econt\Models
 *
 * This model is two in one:
 * @see https://ee.econt.com/services/Shipments/#RequestCourierStatus
 * @see https://ee.econt.com/services/Shipments/#RequestCourierStatusResultElement
 */
class CourierRequestStatus extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'enum:'.\MikeyDevelops\Econt\Enums\RequestCourierStatusType::class,
    ];

    /**
     * Alias for properties.
     * Keys of the array are the alias and the values are the name of the property that is aliased.
     *
     * @var array
     */
    protected $aliases = [
        'rejectReason' => 'reject_reason',
    ];
}
