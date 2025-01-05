<?php

namespace MikeyDevelops\Econt\Models;

use MikeyDevelops\Econt\Models\Model;

/**
 * Parameters for Three Way Logistics Method.
 *
 * @property  string  $requester_name
 * @property  string  $requester_phone
 * @property  string  $requester_email
 * @property  string  $requester_company_name
 * @property  string  $requester_username
 * @property  string  $supplier_company_name
 * @property  string  $supplier_contact_person
 * @property  string  $supplier_phone
 * @property  string  $supplier_city
 * @property  string  $supplier_address
 * @property  string  $supplier_date_for_visit
 * @property  string  $supplier_time_for_visit
 * @property  string  $receiver_name
 * @property  string  $receiver_company_name
 * @property  string  $receiver_phone
 * @property  string  $receiver_email
 * @property  string  $description_shipment_description
 * @property  string  $description_shipment_count
 * @property  string  $description_shipment_weight
 * @property  string  $description_additional_instructions
 * @property  string  $description_payment_sum_to_supplier
 * @property  string  $delivery_details_city
 * @property  string  $delivery_details_address
 * @property  string  $delivery_details_office
 * @property  string  $dc
 * @property  string  $dccp
 * @property  string  $email_on_delivery
 * @property  string  $invoice_before_pay
 * @property  string  $preview
 * @property  string  $test
 * @property  string  $payment_delivery_and_return_by_me
 * @property  string  $payment_return_by_me
 * @property  string  $payment_delivery_by_requester
 * @property  string  $payment_delivery_by_receiver
 * @property  string  $oc_sum
 * @property  string  $cd_sum
 * @property  string  $priority_delivery_time_before
 * @property  string  $priority_delivery_time_after
 * @property  string  $priority_delivery_time_in
 *
 * @see https://ee.econt.com/services/ThreeWayLogistics/#ThreeWayLogisticsService-threeWayLogistics
 */
class ThreeWayParameters extends Model
{
    /**
     * A list of required attributes that when validating if missing from the model, an error would be thrown.
     *
     * @var string[]
     */
    protected array $required = [
        'requester_name', 'requester_phone', 'requester_email', 'requester_company_name', 'requester_username',
        'supplier_company_name', 'supplier_contact_person', 'supplier_phone', 'supplier_city', 'supplier_address', 'supplier_date_for_visit', 'supplier_time_for_visit',
        'receiver_name', 'receiver_company_name', 'receiver_phone', 'receiver_email',
        'description_shipment_description', 'description_shipment_count', 'description_shipment_weight', 'description_additional_instructions', 'description_payment_sum_to_supplier',
        'delivery_details_city', 'delivery_details_address', 'delivery_details_office',
        'dc', 'dccp', 'email_on_delivery', 'invoice_before_pay', 'preview', 'test',
        'payment_delivery_and_return_by_me', 'payment_return_by_me', 'payment_delivery_by_requester', 'payment_delivery_by_receiver',
        'oc_sum', 'cd_sum',
        'priority_delivery_time_before', 'priority_delivery_time_after', 'priority_delivery_time_in',
    ];
}
