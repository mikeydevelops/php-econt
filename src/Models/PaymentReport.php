<?php

namespace MikeyDevelops\Econt\Models;

/**
 * A payment report entry.
 *
 * @property  integer  $num  Shipment number.
 * @property  string  $type  CoD or money transfer.
 * @property  string  $payType  Payment type office, address or bank.
 * @property  string  $payDate  Date of payment.
 * @property  float  $amount   The amount of money paid.
 * @property  string  $currency  The currency of the payment.
 * @property  string  $createdTime  The time the payment was created.
 *
 * @see https://ee.econt.com/services/PaymentReport/#PaymentReportRow
 */
class PaymentReport extends Model
{
    //
}
