<?php

namespace MikeyDevelops\Econt\Resources;

use MikeyDevelops\Econt\Resources\Resource;

/**
 * Interface with Shipment Label service.
 *
 * @see https://ee.econt.com/services/Shipments/#LabelService
 */
class Labels extends Resource
{
    /**
     * The base uri for the resource.
     *
     * @var string
     */
    protected string $baseUri = 'Shipments/LabelService';

    //
}
