<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Enums\Weekday;

/**
 * Payment options for "cash on delivery" service.
 *
 * @property  string  $num  Shipment number.
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $client  The client profile.
 * @property  boolean  $moneyTransfer  Payment with money transfer.
 * @property  boolean  $express  If the delivery of the cash should be express.
 * @property  string  $method  The method of delivering cash. ('office', 'door', 'bank')
 * @property  \MikeyDevelops\Econt\Models\Address  $address  The address of the recipient if $method is 'door'.
 * @property  string  $officeCode  The office code if $method is 'office'.
 * @property  string  $IBAN  International Bank Account Number
 * @property  string  $BIC  Bank Identifier Code
 * @property  string  $bankCurrency  Currency of the bank account.
 * @property  integer[]  $payDays Only if $method is 'bank', either $payDays or $payWeekdays.
 * @property  \MikeyDevelops\Econt\Enums\Weekday[]  $payWeekdays Only if $method is 'bank', either $payDays or $payWeekdays.  The names of the week days in english.
 * @property  string  $additionalInstructions  Additional Instructions
 * @property  integer  $departmentNum
 *
 * @see https://ee.econt.com/services/Profile/#CDPayOptions
 */
class CDPayOptions extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'client' => ClientProfile::class,
        'address' => Address::class,
        'payWeekdays' => 'array:enum,'.Weekday::class,
    ];
}
