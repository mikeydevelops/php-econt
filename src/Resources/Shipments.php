<?php

namespace MikeyDevelops\Econt\Resources;

use MikeyDevelops\Econt\Enums\ShipmentSide;
use MikeyDevelops\Econt\Enums\ShipmentType;
use MikeyDevelops\Econt\Exceptions\EcontException;
use MikeyDevelops\Econt\Models\Address;
use MikeyDevelops\Econt\Models\ClientProfile;
use MikeyDevelops\Econt\Models\Collections\ModelCollection;
use MikeyDevelops\Econt\Resources\Resource;
use MikeyDevelops\Econt\Utilities\DateTime;

/**
 * Interface with Shipment service.
 *
 * @see https://ee.econt.com/services/Shipments/#ShipmentService
 */
class Shipments extends Resource
{
    /**
     * The base uri for the resource.
     *
     * @var string
     */
    protected string $baseUri = 'Shipments/ShipmentService';

    /**
     * Requests statuses of shipments.
     *
     * @param  string[]  $shipmentNumbers  The numbers of the desired shipments.
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection<\MikeyDevelops\Econt\Models\ShipmentStatus>
     * @throws \MikeyDevelops\Econt\Exceptions\HttpException
     */
    public function getShipmentStatuses(array $shipmentNumbers): ModelCollection
    {
        $models = $this->call('getRequestCourierStatus', compact('shipmentNumbers'))
            ->json()['shipmentStatuses'];

        // merge the error field into the status model.
        $models = array_map(function ($model) {
            return array_merge(
                $model['status'],
                ['error' => $model['error'] ?? null],
            );
        }, $models);

        return $this->newModelCollection($models, \MikeyDevelops\Econt\Models\ShipmentStatus::class);
    }

    /**
     * Creates a courier request.
     *
     * @param  \MikeyDevelops\Econt\Models\ClientProfile  $client  The client that is sending the shipment.
     * @param  \MikeyDevelops\Econt\Models\Address  $address  Where the courier will pick the shipment from.
     * @param  \MikeyDevelops\Econt\Enums\ShipmentType|string  The shipment type.
     * @param  string|integer|\DateTimeInterface  $from  Indicates the beginning of the time the courier can collect the shipment.
     * @param  string|integer|\DateTimeInterface  $to  Indicates the end of the time the courier can collect the shipment.
     * @param  float  $weight  The weight of the shipment in kilograms.
     * @param  integer  $count  [optional] The amount of shipments you are going to be sending.
     * @param  \MikeyDevelops\Econt\Models\ClientProfile|null  $agent  [optional] Authorized person.
     * @param  string[]  $shipments  Prepared (not yet received) shipment numbers.
     * @param  integer|null  $pack12  Motorbike stand rental.
     * @return string  The id of the courier request.
     *
     * @see https://ee.econt.com/services/Shipments/#ShipmentService-requestCourier
     */
    public function requestCourier(ClientProfile $client, Address $address, $type, $from, $to, float $weight, int $count = 1, ?ClientProfile $agent = null, array $shipments = [], ?int $pack12 = null): string
    {
        $type = ShipmentType::from($type);
        $count = count($shipments) > $count ? count($shipments) : $count;

        $params = array_filter([
            'requestTimeFrom' => DateTime::create($from)->getTimestamp(),
            'requestTimeTo' => DateTime::create($to)->getTimestamp(),
            'shipmentType' => $type,
            'shipmentPackCount' => $count,
            'shipmentWeight' => $weight,
            'senderClient' => $client,
            'senderAddress' => $address,
            'senderAgent' => $agent,
            'attachShipments' => $shipments,
            'pack12' => $pack12,
        ]);

        $response = $this->call('requestCourier', $params);

        return $response->json()['courierRequestID'];
    }

    /**
     * Requests statuses of courier requests.
     *
     * @param  string[]  $requestIds  IDs of courier requests.
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection<\MikeyDevelops\Econt\Models\CourierRequestStatus>|\MikeyDevelops\Econt\Models\CourierRequestStatus[]
     * @throws \MikeyDevelops\Econt\Exceptions\EcontException
     *
     * @see https://ee.econt.com/services/Shipments/#ShipmentService-getRequestCourierStatus
     */
    public function getRequestCourierStatus(array $requestIds): ModelCollection
    {
        $models = $this->call('getRequestCourierStatus', ['requestCourierIds' => $requestIds])
            ->json()['requestCourierStatus'];

        // merge the error field into the status model.
        $models = array_map(function ($model) {
            return array_merge(
                $model['status'],
                ['error' => $model['error'] ?? null],
            );
        }, $models);

        return $this->newModelCollection($models, \MikeyDevelops\Econt\Models\CourierRequestStatus::class);
    }

    /**
     * Requests statuses of courier requests. Alias for getRequestCourierStatus.
     *
     * @param  array  $requestIds  IDs of courier requests.
     * @return \MikeyDevelops\Econt\Models\Collections\ModelCollection
     * @throws \MikeyDevelops\Econt\Exceptions\EcontException
     *
     * @see \MikeyDevelops\Econt\Resources\Shipments::getRequestCourierStatus()
     */
    public function getCourierRequestStatus(array $requestIds): ModelCollection
    {
        return $this->getRequestCourierStatus($requestIds);
    }

    /**
     * Get my AWB (Air Waybills).
     *
     * @param  string  $dateTo  Format: Y-m-d. End date for shipment preparation.
     * @param  string|null  $dateFrom  [optional] Format: Y-m-d. Start date for shipment preparation.
     * @param  integer|null $page  [optional] The page.
     * @param  \MikeyDevelops\Econt\Enums\ShipmentSide|null  $side  [optional]  The side of the shipment.
     * @return void
     *
     * @see https://ee.econt.com/services/Shipments/#ShipmentService-getMyAWB
     */
    public function getMyAWB(string $dateTo, ?string $dateFrom = null, ?int $page = null, ?ShipmentSide $side = null)
    {
        $params = array_filter(compact('dateFrom', 'dateTo', 'page', 'side'));

        // $this->call('getMyAWB', $params)->json();

        throw new EcontException(static::class . "::getMyAWB is not fully implemented! :(");
    }

    /**
     * Set ITU (International Telecommunication Union) country code for shipment.
     *
     * @param  string  $awbBarcode  Shipment number.
     * @param  string  $truckRegNumber  Truck registration number.
     * @param  string  $ituCode  ITU (International Telecommunication Union) country code.
     * @return static
     *
     * @see https://ee.econt.com/services/Shipments/#ShipmentService-setITUCode
     */
    public function setITUCode(string $awbBarcode, string $truckRegNumber, string $ituCode): self
    {
        $this->call('setITUCode', [
            'awbBarcode' => $awbBarcode,
            'truckRegNumber' => $truckRegNumber,
            'ITU_code' => $ituCode,
        ]);

        return $this;
    }
}
