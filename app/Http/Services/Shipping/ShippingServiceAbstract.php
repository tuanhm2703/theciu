<?php

namespace App\Http\Services\Shipping;

use App\Enums\OrderStatus;
use App\Models\Address;
use App\Models\District;
use App\Http\Services\Shipping\Models\PickupShift;
use App\Http\Services\Shipping\GHNService;
use App\Http\Services\Shipping\GHTKService;
use App\Models\Config;
use App\Models\Order;
use App\Models\ShippingOrder;
use App\Models\ShippingService;
use App\Models\Shop;
use App\Models\Ward;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

abstract class ShippingServiceAbstract {

    protected $service_slug;
    /* These are the paths to the endpoints of the API. */
    protected $create_order_path;
    protected $calculate_delivery_fee_path;
    protected $cancel_order_path;
    protected $get_details_order_path;
    protected $get_pick_shift_path;
    protected $create_store_path;
    protected $preview_shipping_order_path;
    protected $get_ship_service_path;
    protected $calculate_delivery_time_path;

    protected $insurant_percentage;
    protected $client;
    protected $status_string_array;
    protected $fail_order_status;
    protected $picked_status;
    protected $max_order_value;
    protected $min_order_insurance_condition;
    protected $reason_code;
    protected $update_order_reason_code;
    protected $morning_pickup_shift_time;
    protected $afternoon_pickup_shift_time;
    const MORNING_PICKUP_SHIFT_CODE = 1;
    const AFTERNOON_PICKUP_SHIFT_CODE = 2;
    const TOMORROW_MORNING_PICKUP_SHIFT_CODE = 3;
    const TOMORROW_AFTERNOON_PICKUP_SHIFT_CODE = 4;
    const THE_MORNING_OF_THE_DAY_AFTER_TOMORROW_PICKUP_SHIFT_CODE = 5;
    public $config;
    public $shipping_service;
    public function __construct($service_slug) {
        $this->service_slug = $service_slug;
        $this->client = new Client();
        $this->config = Config::select('id')->first();
        $this->shipping_service = ShippingService::where('alias', $service_slug)->first();
    }
    /**
     * It takes an address and returns the district of that address
     *
     * @param Address address The address object that you want to get the district from.
     *
     * @return District The district of the address.
     */
    public function getDistrict(Address $address): District {
        $arr = explode(', ', $address->address_title);
        $district = $arr[1];
        return District::where('name_with_type', $district)->orWhere('name', $district)->first();
    }
    /**
     * > It takes an address and returns the ward that the address belongs to
     *
     * @param Address address The address object that you want to get the ward from.
     *
     * @return Ward The first element of the array.
     */
    public function getWard(Address $address): Ward {
        $arr = explode(', ', $address->address_title);
        $ward = current($arr);
        for ($i = 1; $i < 10; $i++) {
            if (strtolower($ward) == "phường 0$i") {
                $ward = "Phường $i";
                break;
            }
        }
        return Ward::where('name_with_type', $ward)->orWhere('name', $ward)->first();
    }
    /**
     * It takes a path, data, and headers, and returns a response from the API
     *
     * @param path The path to the endpoint you want to hit.
     * @param data The data you want to send to the API.
     * @param headers This is an array of headers that you want to send to the API.
     * @return A response object.
     */
    public function get($path, $headers = []) {
        $url = $this->shipping_service->domain . $this->validPath($path);
        $headers['token'] = $this->shipping_service->token;
        $headers['Content-type'] = 'application/json';
        $response = $this->client->get($url, ['http_errors' => false, 'headers' => $headers]);
        if ($response->getStatusCode() >= 400) {
            Log::info((string) $response->getBody());
            throw new Exception(json_decode((string) $response->getBody())->message, $response->getStatusCode());
        }
        return $response;
    }
    /**
     * It takes a path, data, and headers, and returns a response
     *
     * @param path The path to the endpoint you want to hit.
     * @param data The data to be sent to the API.
     * @param headers This is an array of headers that you want to send with the request.
     *
     * @return A GuzzleHttp\Psr7\Response object.
     */
    public function post($path, $data = [], $headers = []) {
        $url = $this->shipping_service->domain . $this->validPath($path);
        $headers['token'] = $this->shipping_service->token;
        $headers['Content-Type'] = 'application/json';
        $response = $this->client->post($url, ['http_errors' => false, 'headers' => $headers, 'body' => json_encode($data)]);
        return $response;
    }
    /**
     *
     *
     * @param service_slug The slug of the service you want to use.
     */
    public function setServiceSlug($service_slug) {
        $this->service_slug = $service_slug;
    }
    /**
     * It returns the service slug.
     *
     * @return The service slug.
     */
    public function getServiceSlug() {
        return $this->service_slug;
    }
    /**
     * > This function takes a string and returns a string
     *
     * @param String path The path to the file you want to upload.
     *
     * @return The path with a leading slash.
     */
    public function validPath(String $path) {
        if ($path[0] == '/') $path = substr($path, 1);
        return "/" . $path;
    }
    /**
     * It takes an array of data, sends it to the API, and returns the response
     *
     * @param data An array of the following parameters:
     *
     * @return A JSON object containing the order details.
     */
    public function pushShippingOrder($data) {
        $response = $this->post($this->create_order_path, $data);
        if ($response->getStatusCode() == 200) {
            Log::info("Create shipping order successfully for order with order number: " . $data['order_number']);
            return json_decode((string) $response->getBody());
        } else {
            return null;
        }
    }

    /**
     * It takes in an array of data, and returns a JSON object
     *
     * @param data
     *
     * @return The response is a json object with the following structure:
     * ```
     * {
     *     "delivery_fee": "10.00",
     *     "delivery_time": "10:00 - 11:00",
     *     "delivery_date": "2020-01-01"
     * }
     * ```
     */
    public function calculateDeliveryFee($data) {
        $response = $this->post($this->calculate_delivery_fee_path, $data);
        return json_decode((string) $response->getBody());
    }
    /**
     * > Calculate the insurance fee for an order
     *
     * @param total the total amount of the order
     *
     * @return The insurance fee.
     */
    public function calculateInsuranceFee(float $total) {
        if ($total < $this->min_order_insurance_condition) {
            return 0;
        }
        return $total * $this->insurant_percentage / 100;
    }
    /**
     * It takes a code as a parameter, makes a GET request to the API, and returns the response as a
     * JSON object
     *
     * @param code The order code
     *
     * @return Object with the order details.
     */
    public function getOrder($code) {
        $response = $this->get($this->get_details_order_path . $code);
        if ($response->getStatusCode() == 200) {
            return json_decode((string) $response->getBody());
        }
        return null;
    }

    /**
     * It creates a new shipping order history record
     *
     * @param shipping_order_data An array of data that will be used to create a new shipping order
     * history.
     *
     * @return An instance of the ShippingOrderHistory model.
     */
    public function createShippingOrderHistory($shipping_order_data) {
        $order_status = $this->getOrderStatusByShippingOrderStatus($shipping_order_data->status_code, $shipping_order_data->reason_code);
        $shipping_order = ShippingOrder::with('shipping_service', 'order')->findOrFail($shipping_order_data->shipping_order_id);
        if ($order_status != null) {
            if ($order_status == OrderStatus::STATUS_CANCELLED) {
                $shipping_order->order->reason_cancel = $shipping_order_data->reason;
                $shipping_order->order->canceler = OrderStatus::CANCELER_SHIPPING_SERVICE;
            }
            if ($order_status != $shipping_order->order->order_status_id) {
                $shipping_order->order->order_status_id = $order_status;
                $shipping_order->order->save();
            }
        }

        $shipping_order_data->order_status_id = $shipping_order->order->order_status_id;
        // dd($shipping_order_data->toArray());
        $shipping_order->shipping_order_histories()->create($shipping_order_data->toArray());
    }
    /**
     * It creates an order history for a shipping order.
     *
     * @param shipping_order the shipping order object
     * @param shipping_order_data data from the shipping service
     * @param order_status the status of the order after the shipping service has updated the order.
     */
    public function createOrderHistory(ShippingOrder $shipping_order, array $shipping_order_data, $order_status) {
        switch ($order_status) {
            case OrderStatus::STATUS_CANCELLED:
                $order_history_data['description'] = $shipping_order->shipping_service->name .
                    " hủy đơn hàng " . $shipping_order->order->order_number . "vì " .
                    strtolower($shipping_order_data['status']);
                break;
            case OrderStatus::STATUS_DELIVERING:
                $order_history_data['description'] = $shipping_order->shipping_service->name . " đang giao hàng cho đơn hàng " . $shipping_order->order->order_number;
                break;
            case OrderStatus::STATUS_DELIVERED:
                $order_history_data['description'] = $shipping_order->shipping_service->name . " đã giao thành công cho đơn hàng " . $shipping_order->order->order_number;
                break;
            default:
                return;
                break;
        }
    }
    /**
     * It returns the order status based on the shipping order status
     *
     * @param shipping_order_status The status of the order in the shipping system.
     *
     * @return The order status based on the shipping order status.
     */
    public function getOrderStatusByShippingOrderStatus($shipping_order_status, $reason_code = null) {
        if (in_array($shipping_order_status, $this->fail_order_status)) {
            if (in_array($reason_code, $this->update_order_reason_code)) return null;
            return OrderStatus::STATUS_CANCELLED;
        }
        if (in_array($shipping_order_status, $this->picked_status)) return OrderStatus::STATUS_DELIVERING;
        return null;
    }

    public function createShippingServiceStore($address) {
    }
    public function previewShippingOrder($data) {
    }
    public function getShipServices(Address $shipping_address) {
    }
    public function calculateDeliveryTime($data) {
        $response = $this->post($this->calculate_delivery_time_path, $data);
        return json_decode((string) $response->getBody());
    }
    public function createShippingOrder($data) {
        $response = $this->post($this->create_order_path, $data);
        return json_decode((string) $response->getBody());
    }
    public abstract function getListPickupTime();
    public function getPickupShiftById($id) {
        $now = Carbon::now();
        $soonest = null;
        $latest = null;
        $date = null;
        $time_shift = null;
        switch ($id) {
            case self::MORNING_PICKUP_SHIFT_CODE:
                $time_shift = $this->morning_pickup_shift_time;
                $time_range = explode(' - ', $time_shift);
                $soonest = $time_range[0];
                $latest = $time_range[1];
                $date = $now->format('d-m-Y');
                break;
            case self::AFTERNOON_PICKUP_SHIFT_CODE:
                $time_shift = $this->afternoon_pickup_shift_time;
                $time_range = explode(' - ', $time_shift);
                $soonest = $time_range[0];
                $latest = $time_range[1];
                $date = $now->format('d-m-Y');
                break;
            case self::TOMORROW_MORNING_PICKUP_SHIFT_CODE:
                $time_shift = $this->morning_pickup_shift_time;
                $time_range = explode(' - ', $time_shift);
                $soonest = $time_range[0];
                $latest = $time_range[1];
                $date = $now->clone()->addDay()->format('d-m-Y');
                break;
            case self::TOMORROW_AFTERNOON_PICKUP_SHIFT_CODE:
                $time_shift = $this->afternoon_pickup_shift_time;
                $time_range = explode(' - ', $time_shift);
                $soonest = $time_range[0];
                $latest = $time_range[1];
                $date = $now->clone()->addDay()->format('d-m-Y');
                break;
            case self::THE_MORNING_OF_THE_DAY_AFTER_TOMORROW_PICKUP_SHIFT_CODE:
                $time_shift = $this->morning_pickup_shift_time;
                $time_range = explode(' - ', $time_shift);
                $soonest = $time_range[0];
                $latest = $time_range[1];
                $date = $now->clone()->addDays(2)->format('d-m-Y');
                break;
            default:
                break;
        }
        return new PickupShift("Ca lấy $date ($time_shift)", $id, $date, $soonest, $latest);
    }
    public function convertTimeToPickupShift($time) {

    }
}
