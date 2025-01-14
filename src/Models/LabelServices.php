<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Models\Model;

/**
 * Additional services for the shipping labels.
 *
 * @property  time  $priorityTimeFrom  Earliest time for delivery (format: HH:MM).
 * @property  time  $priorityTimeTo  Latest time for delivery (format: HH:MM).
 * @property  boolean  $deliveryReceipt  Indicates if delivery receipt should be returned to sender (additional service - DC).
 * @property  boolean  $digitalReceipt  Indicates if delivery receipt should be returned to sender with digital receipt (additional service - EDC).
 * @property  boolean  $goodsReceipt  Indicates if confirmation for receiving goods should be delivered to sender (additional service - DC-CP).
 * @property  boolean  $twoWayShipment  Indicates if it is a two-way shipment (additional service - DP).
 * @property  boolean  $deliveryToFloor  Indicates if there is delivery to floor (additional service).
 * @property  integer  $pack5
 * @property  integer  $pack6
 * @property  integer  $pack8
 * @property  integer  $pack9
 * @property  integer  $pack10
 * @property  integer  $pack12
 * @property  integer  $refrigeratedPack  Indicates if the shipment should be transported with a cooler bag (additional service - REF).
 * @property  float  $declaredValueAmount  The declared value of the shipment.
 * @property  string  $declaredValueCurrency  The currency of the declared value of the shipment.
 * @property  float  $moneyTransferAmount  Money transfer amount.
 * @property  boolean  $expressMoneyTransfer  Express money transfer.
 * @property  float  $cdAmount  "Cash on delivery" amount.
 * @property  string  $cdType  "Cash on delivery" accepted types: get or give.
 * @property  string  $cdCurrency  "Cash on delivery" currency.
 * @property  string  $cdPayOptionsTemplate  "Cash on delivery" payment options template.
 * @property  \MikeyDevelops\Econt\Models\CDPayOptions  $cdPayOptions  "Cash on delivery" payment options.
 * @property  boolean  $invoiceBeforePayCD  Providing invoice before payment of "Cash on delivery".
 * @property  boolean  $smsNotification  SMS notifications for the receiver.
 * @property  string  $invoiceNum  Invoice number (up to 11 digits) and date (31.12.21) for department sale.
 *
 * @see https://ee.econt.com/services/Shipments/#ShippingLabelServices
 */
class Label extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'cdPayOptions' => \MikeyDevelops\Econt\Models\CDPayOptions::class,
    ];

    /**
     * Alias for properties.
     * Keys of the array are the alias and the values are the name of the property that is aliased.
     *
     * @var array
     */
    protected $aliases = [
        //
    ];
}
