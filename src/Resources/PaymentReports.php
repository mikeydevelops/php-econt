<?php

namespace MikeyDevelops\Econt\Resources;

use MikeyDevelops\Econt\Models\Collections\ModelCollection;
use MikeyDevelops\Econt\Models\PaymentReport;
use MikeyDevelops\Econt\Resources\Resource;

/**
 * Generate payment reports.
 *
 * @see https://ee.econt.com/services/PaymentReport/
 */
class PaymentReports extends Resource
{
    /**
     * The base uri for the resource.
     *
     * @var string
     */
    protected string $baseUri = 'PaymentReport/PaymentReportService';

    /**
     * The model type for the resource.
     *
     * @var string
     */
    protected $model = PaymentReport::class;

    /**
     * Requests information about the client profiles.
     *
     * @param  string  $dateFrom  The start date for the report. Format: Y-m-d
     * @param  string  $dateTo  The end date for the report. Format: Y-m-d
     * @see https://ee.econt.com/services/PaymentReport/#PaymentReportService-PaymentReport
     */
    public function report(string $dateFrom, string $dateTo): ModelCollection
    {
        return $this->collectionFromResponse(
            $this->call('PaymentReport', compact('dateFrom', 'dateTo')),
            PaymentReport::class,
            'PaymentReportRows'
        );
    }
}
