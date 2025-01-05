<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * A type of day.
 *
 * @method  static  workday()  Workday.
 * @method  static  halfday()  Halfday/Staturday.
 * @method  static  holiday()  Holiday.
 *
 * @see https://ee.econt.com/services/Nomenclatures/#dayType
 */
class DayType extends Enum
{
    private const workday = 'workday';
    private const halfday = 'halfday';
    private const holiday = 'holiday';
}
