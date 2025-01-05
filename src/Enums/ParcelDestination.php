<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * Parcel destinations for ReturnInstructionParams.
 *
 * @method  static  noReturn()  Instruction type for collecting a shipment from the sender.
 * @method  static  sender()  Instruction type for giving over a shipment to the receiver.
 * @method  static  office()  Instruction type for returning a shipment.
 * @method  static  address()  Instruction type for additional services.
 *
 * @see https://ee.econt.com/services/Shipments/#ReturnInstructionParams:~:text=returnParcelDestination
 */
class ParcelDestination extends Enum
{
    private const noReturn = '';
    private const sender = 'sender';
    private const office = 'office';
    private const address = 'address';
}
