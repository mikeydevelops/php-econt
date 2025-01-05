<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Models\Model;

/**
 * A file hosted on Econt's servers.
 *
 * @property  integer  $id  The identification of the file.
 * @property  string  $filename  The name of the hosted file.
 * @property  string  $mimeType  File type (text, xml, application, x-msexcel).
 * @property  string  $URL  The URL address of the hosted file.
 * @property  string  $content  The content of the hosted file. Base 64 encoded binary data.
 *
 * Aliases
 * @property  string  $url  The URL address of the hosted file. Alias for $URL.
 *
 * @see https://ee.econt.com/services/#HostedFile
 */
class HostedFile extends Model
{
    /**
     * Alias for properties.
     * Keys of the array are the alias and the values are the name of the property that is aliased.
     *
     * @var array
     */
    protected $aliases = [
        'url' => 'URL',
    ];
}
