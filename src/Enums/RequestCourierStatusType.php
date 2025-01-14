<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * Status type of a courier request.
 *
 * @method  static  unprocessed()  Not processed.
 * @method  static  processed()  	Processed and assigned to a courier.
 * @method  static  taken()  	Shipment is taken from client's address.
 * @method  static  rejected()  Cancelled by courier.
 * @method  static  rejectedClient()  Cancelled by client.
 *
 * Note: Names differ from docs because I wanted to make them more coherent.
 *
 * @see https://ee.econt.com/services/Shipments/#RequestCourierStatusType
 */
class RequestCourierStatusType extends Enum
{
    private const unprocessed = 'unprocess';
    private const processed = 'process';
    private const taken = 'taken';
    private const rejected = 'reject';
    private const rejectedClient = 'reject_client';
}
