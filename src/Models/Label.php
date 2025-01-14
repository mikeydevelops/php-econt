<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Models\Model;

/**
 * A shipping label.
 *
 * @property  string  $shipmentNumber  Shipment number.
 * @property  string  $previousShipmentNumber  The number of the parent (previous) shipment.
 * @property  string  $previousShipmentReceiverPhone  The phone number of the receiver of the parent (previous) shipment.
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $senderClient  Sender client profile.
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $senderAgent  Authorized sender client profile.
 * @property-read  \MikeyDevelops\Econt\Models\Address  $senderAddress  Address of the sender.
 * @property  string  $senderOfficeCode  Office code of the sender.
 * @property  string  $emailOnDelivery  E-mail for delivery notification.
 * @property  string  $smsOnDelivery  Indicates whether or not a SMS should be send after the delivery.
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $receiverClient  Receiver.
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $receiverAgent  Authorized receiver.
 * @property-read  \MikeyDevelops\Econt\Models\Address  $receiverAddress  Address of the receiver.
 * @property  string  $receiverOfficeCode  Office code of the receiver.
 * @property  integer  $receiverProviderID  Provider ID of the receiver.
 * @property  string  $receiverBIC  BIC of the receiver.
 * @property  string  $receiverIBAN  IBAN of the receiver.
 * @property  string[]  $envelopeNumbers  Envelope numbers.
 * @property  integer  $packCount  Pack count.
 * @property-read  \MikeyDevelops\Econt\Models\Pack[]  $packs  Packs.
 * @property-read  \MikeyDevelops\Econt\Models\ShipmentType  $shipmentType  Shipment type.
 * @property  float  $weight  Weight.
 * @property  boolean  $sizeUnder60cm  Indicates if all shipment dimensions are under 60cm (by default: 'false').
 * @property  float  $shipmentDimensionsL  Shipment dimensions (lenght).
 * @property  float  $shipmentDimensionsW  Shipment dimensions (width).
 * @property  float  $shipmentDimensionsH  Shipment dimensions (height).
 * @property  string  $shipmentDescription  Shipment description.
 * @property  string  $orderNumber  Order number.
 * @property  date  $sendDate  The date when the shipment is sent.
 * @property  string  $holidayDeliveryDay  'Halfday', 'workday', or specific date (yyyy-mm-dd).
 * @property  boolean  $keepUpright  Indicates if the shipment should be kept upright (ON/OFF).
 * @property-read  \MikeyDevelops\Econt\Models\LabelServices  $services  Services.
 * @property-read  \MikeyDevelops\Econt\Models\Instruction[]  $instructions  Instructions.
 * @property  boolean  $payAfterAccept  Indicates whether or not the shipment can be checked before payment. This service will be ignored for shipments from/to automatic post stations..
 * @property  boolean  $payAfterTest  Indicates whether or not the shipment can be tested before payment. This service will be ignored for shipments from/to automatic post stations/Econt Drive..
 * @property  string  $packingListType  Packing list type - file, digital, loading.
 * @property-read  \MikeyDevelops\Econt\Models\PackingData[]  $packingList  Packing list.
 * @property  boolean  $partialDelivery  Indicates whether or not partial delivery is allowed.
 * @property  string  $paymentSenderMethod  Payment method of the sender - <empty>, cash, credit or voucher.
 * @property  string  $paymentReceiverMethod  Payment method of the receiver - <empty>, cash or credit.
 * @property  float  $paymentReceiverAmount  Amount of the payment for the receiver.
 * @property  boolean  $paymentReceiverAmountIsPercent Indicates if the payment due from the receiver is a percentage.
 * @property  string  $paymentOtherClientNumber  The number of the client who is paying as a third party.
 * @property  float  $paymentOtherAmount  Amount to be paid from third party.
 * @property  boolean  $paymentOtherAmountIsPercent  Indicates if the payment due from third party is a percentage.
 * @property  string  $mediator  Mediator for the shipment.
 * @property  string  $paymentToken  Payment token for blocking payments.
 * @property-read  \MikeyDevelops\Econt\Models\CustomsData[]  $customsList  Customs information.
 * @property  string  $customsInvoice  Customs Invoice number / date (31.12.21).
 *
 * Aliases:
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $sender  Sender client profile. Alias for $senderClient.
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $receiver  Receiver client profile. Alias for $receiverClient.
 *
 * @see https://ee.econt.com/services/Shipments/#ShippingLabel
 */
class Label extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'senderClient' => \MikeyDevelops\Econt\Models\ClientProfile::class,
        'senderAgent' => \MikeyDevelops\Econt\Models\ClientProfile::class,
        'receiverClient' => \MikeyDevelops\Econt\Models\ClientProfile::class,
        'receiverAgent' => \MikeyDevelops\Econt\Models\ClientProfile::class,
        'packs' => 'collection:'.\MikeyDevelops\Econt\Models\Pack::class,
        'shipmentType' => 'enum:'.\MikeyDevelops\Econt\Enums\ShipmentType::class,
        'services' => \MikeyDevelops\Econt\Models\LabelServices::class,
        'instructions' => 'collection:'.\MikeyDevelops\Econt\Models\Instruction::class,
        'packingList' => \MikeyDevelops\Econt\Models\PackingData::class,
        'customsList' => \MikeyDevelops\Econt\Models\CustomsData::class,
    ];

    /**
     * Alias for properties.
     * Keys of the array are the alias and the values are the name of the property that is aliased.
     *
     * @var array
     */
    protected $aliases = [
        'sender' => 'senderClient',
        'receiver' => 'receiverClient',
    ];
}
