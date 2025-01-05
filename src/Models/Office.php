<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Enums\ShipmentType;

/**
 * Office of Econt Express. Required fields for identifying an office - code or ID.
 *
 * @property  integer  $id  The office identifier.
 * @property  string  $code  An identifying unique code for the office.
 * @property  boolean  $isMPS  If the office is a mobile post station.
 * @property  boolean  $isAPS  If the office is an automatic post station.
 * @property  string  $name  The name of the office in Bulgarian.
 * @property  string  $nameEn  The name of the office in English.
 * @property  string[]  $phones  A list of phone numbers for the office.
 * @property  string[]  $emails  A list of email addresses for the office.
 * @property  \MikeyDevelops\Econt\Models\Address  $address  The address where the office is located.
 * @property  string  $info  Additional information about the office.
 * @property  string  $currency  The currency the office works with.
 * @property  string  $language  The language the office works with.
 * @property  string  $normalBusinessHoursFrom  Business hours for parcel pickup and delivery from/to an address on weekdays.
 * @property  string  $normalBusinessHoursTo  Business hours for parcel pickup and delivery from/to an address on weekdays.
 * @property  string  $halfBusinessHoursFrom  Business hours for parcel pickup and delivery from/to an address on saturdays.
 * @property  string  $halfBusinessHoursTo  Business hours for parcel pickup and delivery from/to an address on saturdays.
 * @property  string  $sundayBusinessHoursFrom  Business hours for parcel pickup and delivery from/to an address on sundays.
 * @property  string  $sundayBusinessHoursTo  Business hours for parcel pickup and delivery from/to an address on sundays.
 * @property  \MikeyDevelops\Econt\Enums\ShipmentType[]  $shipmentTypes Types of shipments which can be sent/collected to/from the office.
 * @property  string  $partnerCode  Partner code.
 * @property  string  $hubCode  Code of the distribution center associated with the office.
 * @property  string  $hubName  Name, in Bulgarian, of the distribution center associated with the office.
 * @property  string  $hubNameEn  Name, in English, of the distribution center associated with the office.
 * @property  boolean  $isDrive If the office is an Econt Drive.
 */
class Office extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'address' => Address::class,
        'shipmentTypes' => 'array:enum,'.ShipmentType::class,
    ];
}
