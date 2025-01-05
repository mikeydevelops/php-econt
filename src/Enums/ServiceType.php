<?php

namespace MikeyDevelops\Econt\Enums;

use MikeyDevelops\Econt\Enums\Enum;

/**
 * A type of service.
 *
 * @method  static  fromDoorCourier()
 * @method  static  toDoorCourier()
 * @method  static  fromOfficeCourier()
 * @method  static  toOfficeCourier()
 * @method  static  fromDoorCargo()
 * @method  static  toDoorCargo()
 * @method  static  fromOfficeCargo()
 * @method  static  toOfficeCargo()
 * @method  static  fromDoorPost()
 * @method  static  toDoorPost()
 * @method  static  fromOfficePost()
 * @method  static  toOfficePost()
 * @method  static  code1()
 * @method  static  fromDoorCargoExpres()
 * @method  static  toDoorCargoExpres()
 * @method  static  fromOfficeCargoExpres()
 * @method  static  toOfficeCargoExpres()
 * @method  static  toDoorTransPallet()
 * @method  static  toOfficeTransPallet()
 *
 * Enum was based on servingType in:
 * @see https://ee.econt.com/services/Nomenclatures/#ServingOfficeElement
 */
class ServiceType extends Enum
{
    private const fromDoorCourier = 'from_door_courier';
    private const toDoorCourier = 'to_door_courier';
    private const fromOfficeCourier = 'from_office_courier';
    private const toOfficeCourier = 'to_office_courier';
    private const fromDoorCargo = 'from_door_cargo';
    private const toDoorCargo = 'to_door_cargo';
    private const fromOfficeCargo = 'from_office_cargo';
    private const toOfficeCargo = 'to_office_cargo';
    private const fromDoorPost = 'from_door_post';
    private const toDoorPost = 'to_door_post';
    private const fromOfficePost = 'from_office_post';
    private const toOfficePost = 'to_office_post';
    private const code1 = 'code1';
    private const fromDoorCargoExpres = 'from_door_cargo_expres';
    private const toDoorCargoExpres = 'to_door_cargo_expres';
    private const fromOfficeCargoExpres = 'from_office_cargo_expres';
    private const toOfficeCargoExpres = 'to_office_cargo_expres';
    private const toDoorTransPallet = 'to_door_trans_pallet';
    private const toOfficeTransPallet = 'to_office_trans_pallet';
}
