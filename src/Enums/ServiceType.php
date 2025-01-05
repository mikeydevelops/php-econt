<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * A type of service.
 *
 * @method  static  from_door_courier()
 * @method  static  to_door_courier()
 * @method  static  from_office_courier()
 * @method  static  to_office_courier()
 * @method  static  from_door_cargo()
 * @method  static  to_door_cargo()
 * @method  static  from_office_cargo()
 * @method  static  to_office_cargo()
 * @method  static  from_door_post()
 * @method  static  to_door_post()
 * @method  static  from_office_post()
 * @method  static  to_office_post()
 * @method  static  code1()
 * @method  static  from_door_cargo_expres()
 * @method  static  to_door_cargo_expres()
 * @method  static  from_office_cargo_expres()
 * @method  static  to_office_cargo_expres()
 * @method  static  to_door_trans_pallet()
 * @method  static  to_office_trans_pallet()
 *
 * Enum was based on servingType in:
 * @see https://ee.econt.com/services/Nomenclatures/#ServingOfficeElement
 */
class ServiceType extends Enum
{
    private const from_door_courier = 'from_door_courier';
    private const to_door_courier = 'to_door_courier';
    private const from_office_courier = 'from_office_courier';
    private const to_office_courier = 'to_office_courier';
    private const from_door_cargo = 'from_door_cargo';
    private const to_door_cargo = 'to_door_cargo';
    private const from_office_cargo = 'from_office_cargo';
    private const to_office_cargo = 'to_office_cargo';
    private const from_door_post = 'from_door_post';
    private const to_door_post = 'to_door_post';
    private const from_office_post = 'from_office_post';
    private const to_office_post = 'to_office_post';
    private const code1 = 'code1';
    private const from_door_cargo_expres = 'from_door_cargo_expres';
    private const to_door_cargo_expres = 'to_door_cargo_expres';
    private const from_office_cargo_expres = 'from_office_cargo_expres';
    private const to_office_cargo_expres = 'to_office_cargo_expres';
    private const to_door_trans_pallet = 'to_door_trans_pallet';
    private const to_office_trans_pallet = 'to_office_trans_pallet';
}
