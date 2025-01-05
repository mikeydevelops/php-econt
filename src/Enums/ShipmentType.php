<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * Types of shipments
 *
 * @method  static  document()  Documents (up to 0.5kg)
 * @method  static  pack()  Parcel (up to 50kg)
 * @method  static  post_pack()  Post parcel (up to 20kg, 60x60x60cm and subcode = office-office)
 * @method  static  pallet()  Pallet (80x120x180cm and up to 1000kg)
 * @method  static  cargo()  Cargo express (palletized shipment over 80x120x180cm up to 200x200x180cm and up to 500kg)
 * @method  static  documentpallet()  Pallet + documents
 * @method  static  big_letter()  Big Letter
 * @method  static  small_letter()  Small Letter
 * @method  static  money_transfer()  Money transfer
 * @method  static  pp()  Post transfer
 *
 * @see https://ee.econt.com/services/Shipments/#ShipmentType
 */
class ShipmentType extends Enum
{
    private const document = 'document';
    private const pack = 'pack';
    private const post_pack = 'post_pack';
    private const pallet = 'pallet';
    private const cargo = 'cargo';
    private const documentpallet = 'documentpallet';
    private const big_letter = 'big_letter';
    private const small_letter = 'small_letter';
    private const money_transfer = 'money_transfer';
    private const pp = 'pp';
}
