<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Models\Model;

/**
 * Parameters for returning shipment instructions.
 *
 * TODO: fix confusion with $rejectAction.
 *
 * @property-read  \MikeyDevelops\Econt\Enums\ParcelDestination  $returnParcelDestination  Destination of the return parcel.
 * @property  boolean  $returnParcellsDocument  Indicates if the return parcel is document.
 *                                              (true -> the return shipment is a document,
 *                                               false -> the return shipment is the same type as the original)
 * @property  boolean  $returnParcelIsEmptyPallet  Indicates if the return parcel is will have empty pallets.
 *                     (true -> the return shipment is one or more empty pallets,
 *                      false -> the return shipment is the same type as the original).
 *                      This option only applies to shipment types of cargo, pallet or documentpallet.
 *                      The count of all pallet types to return cannot exceed the shipment pack count.
 * @property  integer  $emptyPalletEuro  Count of euro pallets to return.
 * @property  integer  $emptyPallet80  Count of pallets to return with size 80x120.
 * @property  integer  $emptyPallet100  Count of pallets to return with size 100x120.
 * @property  integer  $emptyPallet120  Count of pallets to return with size 120x120.
 * @property  integer  $daysUntilReturn  The maximum period (in days) for sending the return shipment.
 * @property  string  $returnParcelPaymentSide  Payer of the return shipment (sender, receiver).
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $returnParcelReceiverClient  Receiver for the return shipment (if empty -> original sender).
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $returnParcelReceiverAgent  Receiver's authorized person for the return shipment (if empty -> original sender's authorized person).
 * @property  string  $returnParcelReceiverOfficeCode  Receiver's office code for the return shipment (if empty -> original sender's office code).
 * @property-read  \MikeyDevelops\Econt\Models\Address  $returnParcelReceiverAddress  Receiver's address for the return shipment (if empty -> original sender's address).
 * @property  boolean  $printReturnParcel  If label for return shipment should be generated upon creation of the first shipment.
 * @property-read  \MikeyDevelops\Econt\Enums\RejectAction  $rejectAction  The action to take if the shipment is rejected.
 * @property  string  $rejectInstruction  Text instruction if the shipment is rejected by the receiver. Cannot be used in conjunction with $rejectContact, $rejectReturnReceiver or $rejectReturnToSender.
 * @property  string  $rejectContact  Phone or e-mail contact if the shipment is rejected by the receiver. Cannot be used in conjunction with $rejectInstruction, $rejectReturnReceiver or $rejectReturnToSender.
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $rejectReturnClient  Client, to whom the original (first) shipment should be returned.
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $rejectReturnAgent  Authorized person, to whom the original (first) shipment should be returned.
 * @property  string  $rejectReturnOfficeCode  The code of the office, where the original (first) shipment should be returned.
 * @property-read  \MikeyDevelops\Econt\Models\Address  $rejectReturnAddress  Address, where the original (first) shipment should be returned to.
 * @property  string  $rejectOriginalParcelPaySide  Payer of the original (first) shipment if it is rejected by the receiver after review (sender, receiver).
 * @property  string  $rejectReturnParcelPaySide  Payer of the return shipment if the original (first) is rejected by the receiver after review (sender, receiver).
 * @property  boolean  $signatureDocuments  Marks if the returning documents should be signed by the client ($returnParcelIsDocument should be 'true').
 * @property  string  $signaturePenColor  The color of the pen, which have to be used for signing the documents.
 * @property  integer  $signatureCount  Number of total signatures that have to be done.
 * @property  string  $signaturePageNumbers  Page numbers of the document where the client should put his signature.
 * @property  string  $signatureOtherInstructions  Other or additional instructions in free text.
 * @property  boolean  $executeIfRejectedWithoutReview  Instruction to be fulfilled in case shipment is refused without being inspected.
 * @property  boolean  $useReturnAddressForInstruction  The specified reject address will also be used for return instruction.
 * @property  integer  $executeIfNotTaken  Activate return instruction if shipment is unclaimed after X days.
 *
 * @see https://ee.econt.com/services/Shipments/#ReturnInstructionParams
 */
class ReturnInstruction extends Model
{

    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'returnParcelDestination' => 'enum:'.\MikeyDevelops\Econt\Enums\ParcelDestination::class,
        'returnParcelReceiverClient' => \MikeyDevelops\Econt\Models\ClientProfile::class,
        'returnParcelReceiverAgent' => \MikeyDevelops\Econt\Models\ClientProfile::class,
        'returnParcelReceiverAddress' => \MikeyDevelops\Econt\Models\Address::class,
        'rejectAction' => 'enum:'.\MikeyDevelops\Econt\Enums\RejectAction::class,
        'rejectReturnClient' => \MikeyDevelops\Econt\Models\ClientProfile::class,
        'rejectReturnAgent' => \MikeyDevelops\Econt\Models\ClientProfile::class,
        'rejectReturnAddress' => \MikeyDevelops\Econt\Models\Address::class,
    ];
}
