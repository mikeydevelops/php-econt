<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * Weekdays
 *
 * @method  static  monday()  Monday
 * @method  static  tuesday()  Tuesday
 * @method  static  wednesday()  Wednesday
 * @method  static  thursday()  Thursday
 * @method  static  friday()  Friday
 * @method  static  saturday()  Saturday
 * @method  static  sunday()  Sunday
 *
 * @see https://ee.econt.com/services/#Weekday
 */
class Weekday extends Enum
{
    private const monday = 'monday';
    private const tuesday = 'tuesday';
    private const wednesday = 'wednesday';
    private const thursday = 'thursday';
    private const friday = 'friday';
    private const saturday = 'saturday';
    private const sunday = 'sunday';
}
