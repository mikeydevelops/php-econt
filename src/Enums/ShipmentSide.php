<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * A side of a shipping contract.
 *
 * @method  static  sender()  Only the sender side.
 * @method  static  receiver()  Only the receiver side.
 * @method  static  all()  All of the sides.
 *
 * @see https://ee.econt.com/services/Shipments/#ShipmentService-getMyAWB:~:text=Shipment%20side
 */
class ShipmentSide extends Enum
{
    private const sender = 'sender';
    private const receiver = 'receiver';
    private const all = 'all';
}
