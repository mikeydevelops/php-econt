<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * Instruction types.
 *
 * @method  static  contact()  Contact sender. (rejectContact)
 * @method  static  instruction()  Text with instructions. (rejectInstruction)
 * @method  static  returnToSender()  Return to sender.
 * @method  static  returnToOffice()  Return to office. (rejectReturnClient, RejectReturnAgent, RejectReturnOfficeCode)
 * @method  static  returnToAddress()  Return to address. (rejectReturnClient, RejectReturnAgent, RejectReturnOfficeCode)
 *
 * @see https://ee.econt.com/services/Shipments/#ReturnInstructionParams:~:text=rejectAction
 */
class RejectAction extends Enum
{
    private const contact = 'contact';
    private const instruction = 'instruction';
    private const returnToSender = 'return_to_sender';
    private const returnToOffice = 'return_to_office';
    private const returnToAddress = 'return_to_address';
}
