<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Models\Model;

/**
 * An error.
 *
 * @property  string  $type  The type of error - usually the exception class name.
 * @property  string  $message  The error message in user language.
 * @property  string[]  $fields  The fields which caused the error.
 * @property  static[]  $innerErrors The causes of the error. Previous errors.
 *
 * @see https://ee.econt.com/services/#Error
 */
class Error extends Model
{
    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'innerErrors' => 'array:'. Error::class,
    ];
}
