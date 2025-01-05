<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * Instruction types.
 *
 * @method  static  take()  Instruction type for collecting a shipment from the sender.
 * @method  static  give()  Instruction type for giving over a shipment to the receiver.
 * @method  static  return()  Instruction type for returning a shipment.
 * @method  static  services()  Instruction type for additional services.
 *
 * @see https://ee.econt.com/services/Shipments/#InstructionType
 */
class InstructionType extends Enum
{
    private const take = 'take';
    private const give = 'give';
    private const return = 'return';
    private const services = 'services';
}
