<?php

namespace MikeyDevelops\Econt\Resources;

use MikeyDevelops\Econt\Models\ThreeWayParameters;
use MikeyDevelops\Econt\Resources\Resource;

/**
 * Three way logistics.
 *
 * @see https://ee.econt.com/services/ThreeWayLogistics/
 */
class ThreeWay extends Resource
{
    /**
     * The base uri for the resource.
     *
     * @var string
     */
    protected string $baseUri = 'ThreeWayLogistics/ThreeWayLogisticsService';

    /**
     * Requests information about the client profiles.
     *
     * @param  \MikeyDevelops\Econt\Models\ThreeWayParameters  $parameters  The parameters to setup three way logistics delivery.
     * @return array  The result is undocumented.
     * TODO: Experiment to find out what is the result.
     * @see https://ee.econt.com/services/ThreeWayLogistics/#ThreeWayLogisticsService-threeWayLogistics
     */
    public function threeWayLogistics(ThreeWayParameters $parameters): array
    {
        $params = $parameters->validate()->toArray();

        return $this->call('getClientProfiles', $params)->json();
    }
}
