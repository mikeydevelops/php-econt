<?php

namespace MikeyDevelops\Econt\Models;

/**
 * Country. Required fields for valid country - ID or code (code2 or code3)
 *
 * @property  integer  $id  The country identifier.
 * @property  string  $code2  ISO 3166-1 alpha-2 code (e.g. BG, GB, GR)
 * @property  string  $code3  ISO 3166-1 alpha-3 code (e.g. BGR ,GBR, GRC)
 * @property  string  $name  The Bulgarian name of the country.
 * @property  string  $nameEn  The international name of the country.
 * @property  boolean  $isEU  If the country is member of the European Union.
 *
 * @see https://ee.econt.com/services/Nomenclatures/#Country
 */
class Country extends Model
{
    /**
     * Alias for properties.
     * Keys of the array are the alias and the values are the name of the property that is aliased.
     *
     * @var array
     */
    protected $aliases = [
        'neighborhood' => 'quarter',
    ];
}
