<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * Types of shipments
 *
 * @method  static  document()  Documents (up to 0.5kg)
 * @method  static  pack()  Parcel (up to 50kg)
 * @method  static  postPack()  Post parcel (up to 20kg, 60x60x60cm and subcode = office-office)
 * @method  static  pallet()  Pallet (80x120x180cm and up to 1000kg)
 * @method  static  cargo()  Cargo express (palletized shipment over 80x120x180cm up to 200x200x180cm and up to 500kg)
 * @method  static  documentPallet()  Pallet + documents
 * @method  static  bigLetter()  Big Letter
 * @method  static  smallLetter()  Small Letter
 * @method  static  moneyTransfer()  Money transfer
 * @method  static  postTransfer()  Post transfer
 *
 * @see https://ee.econt.com/services/Shipments/#ShipmentType
 */
class ShipmentType extends Enum
{
    private const document = 'document';
    private const pack = 'pack';
    private const postPack = 'post_pack';
    private const pallet = 'pallet';
    private const cargo = 'cargo';
    private const documentPallet = 'documentpallet';
    private const bigLetter = 'big_letter';
    private const smallLetter = 'small_letter';
    private const moneyTransfer = 'money_transfer';
    private const postTransfer = 'pp';
}
