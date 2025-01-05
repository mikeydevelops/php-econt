<?php

namespace MikeyDevelops\Econt\Resources;

use MikeyDevelops\Econt\Models\CDPayOptions;
use MikeyDevelops\Econt\Models\Collections\ModelCollection;
use MikeyDevelops\Econt\Models\Collections\ProfileCollection;
use MikeyDevelops\Econt\Models\Profile;
use MikeyDevelops\Econt\Resources\Resource;

/**
 * Interface with Profile Service.
 *
 * @see https://ee.econt.com/services/Profile/
 */
class Profiles extends Resource
{
    /**
     * The base uri for the resource.
     *
     * @var string
     */
    protected string $baseUri = 'Profile/ProfileService';

    /**
     * The model type for the resource.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Requests information about the client profiles.
     *
     * @return \MikeyDevelops\Econt\Models\Profile[]|\MikeyDevelops\Econt\Models\Collections\ModelCollection<\MikeyDevelops\Econt\Models\Profile>
     * @see https://ee.econt.com/services/Profile/#ProfileService-getClientProfiles
     */
    public function getClientProfiles(): ModelCollection
    {
        return $this->newModelCollection($this->call('getClientProfiles')->json()['profiles']);
    }

    /**
     * Creates a "cash on delivery" agreement for payment options.
     *
     * @return \MikeyDevelops\Econt\Models\CDPayOptions
     * @see https://ee.econt.com/services/Profile/#ProfileService-createCDAgreement
     */
    public function createCDAgreement(CDPayOptions $cDPayOptions): CDPayOptions
    {
        return $this->newModelInstance(
            $this->call('createCDAgreement', compact('cdPayOptions'))->json()['cdPayOptions'],
            CDPayOptions::class
        );
    }
}
