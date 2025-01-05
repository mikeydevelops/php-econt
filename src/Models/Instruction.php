<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Models\Model;

/**
 * Additional instructions for receiving, giving over or returning of shipment.
 *
 * @property  integer  $id  The identification of the instruction.
 * @property-read  \MikeyDevelops\Econt\Enums\InstructionType|null  $type  The type of the instruction.
 * @property  string|null  $title  The title of the instruction for receiving or giving over a shipment.
 * @property  string|null  $description  Content of the instruction for receiving or giving over a shipment.
 * @property-read  \MikeyDevelops\Econt\Models\HostedFile[]  $attachments  Attached files with instructions for receiving or giving over a shipment.
 * @property-read  \MikeyDevelops\Econt\Models\HostedFile  $voiceDescription  Recorded voice message with instruction for receiving or giving over a shipment (mp3).
 * @property-read  \MikeyDevelops\Econt\Models\ReturnInstructionParams  $returnInstructionParams  Instruction parameters for returning a shipment.
 * @property  string  $name  Instruction template name.
 * @property  boolean  $applyToAllParcels  Whether or not the template should be applied for all sender's shipments.
 * @property  string[]  $applyToReceivers  Whether or not the template should be applied for all sender's shipments to given receivers.
 *
 * @see https://ee.econt.com/services/Shipments/#Instruction
 */
class Instruction extends Model
{

    /**
     * An array of properties that should be cast to other types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'enum:'.\MikeyDevelops\Econt\Enums\InstructionType::class,
        'attachments' => 'array:'.\MikeyDevelops\Econt\Models\HostedFile::class,
        'voiceDescription' => \MikeyDevelops\Econt\Models\HostedFile::class,
        'returnInstructionParams' => \MikeyDevelops\Econt\Models\ReturnInstructionParams::class,
    ];
}
