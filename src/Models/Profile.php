<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Models\Address;
use MikeyDevelops\Econt\Models\CDPayOptions;
use MikeyDevelops\Econt\Models\ClientProfile;
use MikeyDevelops\Econt\Models\Instruction;
use MikeyDevelops\Econt\Models\Model;

/**
 * Information about the client's addresses, "cash on delivery" payment options and templates with instructions
 *
 * @property-read  \MikeyDevelops\Econt\Models\ClientProfile  $client  Client information.
 * @property-read  \MikeyDevelops\Econt\Models\Address[]  $addresses
 * @property-read  \MikeyDevelops\Econt\Models\CDPayOptions[]  $cdPayOptions  "Cash on delivery" payment options.
 * @property-read  \MikeyDevelops\Econt\Models\Instruction[]  $instructionTemplates  Templates with instructions.
 *
 * @see https://ee.econt.com/services/Profile/#ProfilesResponseElement
 */
class Profile extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'client' => ClientProfile::class,
        'addresses' => 'collection:'.Address::class,
        'cdPayOptions' => 'collection:'.CDPayOptions::class,
        'instructionTemplates' => 'collection:'.Instruction::class,
    ];
}
