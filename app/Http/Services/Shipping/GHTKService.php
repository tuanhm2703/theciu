<?php

namespace App\Http\Services\Shipping;

use App\Models\Address;
use App\Enums\ShippingServiceType;
use App\Http\Services\Shipping\Models\DeliveryFeeResponseData;
use App\Http\Services\Shipping\Models\PickupShift;
use App\Http\Services\Shipping\Models\ShippingOrderHistoryData;
use App\Http\Services\Shipping\ShippingServiceAbstract;
use App\Models\Order;
use App\Models\ShippingOrder;
use App\Models\ShippingService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class GHTKService extends ShippingServiceAbstract {
    const PICKUP_TIME_ESTIMATE = 4;

    const INNER_CITY_ROUTE_DELIVERY_HOURS = 6;

    const INNER_DOMAIN_ROUTE_DELIVERY_HOURS = 24;

    const SPECIAL_ROUTE_DELIVERY_HOURS = [
        [
            'service_type_id' => ShippingServiceType::STANDARD_SHIPPING_SERVICE_CODE,
            'delivery_time' => 72
        ],
        [
            'service_type_id' => ShippingServiceType::FAST_SHIPPING_SERVICE_CODE,
            'delivery_time' => 24
        ]
    ];
    const OUTER_DOMAIN_ROUTE_DELIVERY_HOURS = [
        [
            'service_type_id' => ShippingServiceType::STANDARD_SHIPPING_SERVICE_CODE,
            'delivery_time' => 72
        ],
        [
            'service_type_id' => ShippingServiceType::FAST_SHIPPING_SERVICE_CODE,
            'delivery_time' => 48
        ]
    ];
    const SPECIAL_PROVINCES = [
        'Hồ Chí Minh',
        'Hà Nội',
        'Đà Nẵng'
    ];

    const INNER_CITY_ROUTE_CODE = 1;
    const INNER_DOMAIN_ROUTE_CODE = 2;
    const SPECIAL_ROUTE_CODE = 3;
    const OUTER_DOMAIN_ROUTE_CODE = 4;
    const SUCCESS_ORDER_STATUS = '5';

    const SHIP_SERVICE_LIST = [
        'road' => 'Tiêu chuẩn',
        'fly' => 'Nhanh'
    ];

    public function __construct() {
        parent::__construct(ShippingServiceType::GIAO_HANG_TIET_KIEM_ALIAS);
        /* Setting the path to create an order. */
        $this->create_order_path = '/services/shipment/order';
        /* Setting the path to calculate the delivery fee. */
        $this->calculate_delivery_fee_path = '/services/shipment/fee';
        /* Setting the path to cancel an order. */
        $this->cancel_order_path = '/services/shipment/cancel';
        /* Setting the path to get the details of an order. */
        $this->get_details_order_path = '/services/shipment/v2/';
        /* Setting the minimum order insurance condition to 1000000 and the insurance percentage to
        0.5. */
        $this->min_order_insurance_condition = 1000000;
        $this->insurant_percentage = 0.5;
        $this->status_string_array = [
            "-1" => "Hủy đơn hàng",
            "1" => "Chưa tiếp nhận",
            "2" => "Đã tiếp nhận",
            "3" => "Đã lấy hàng/Đã nhập kho",
            "4" => "Đã điều phối giao hàng/Đang giao hàng",
            "5" => "Đã giao hàng/Chưa đối soát",
            "6" => "Đã đối soát",
            "7" => "Không lấy được hàng",
            "8" => "Hoãn lấy hàng",
            "9" => "Không giao được hàng",
            "10" => "Delay giao hàng",
            "11" => "Đã đối soát công nợ trả hàng",
            "12" => "Đã điều phối lấy hàng/Đang lấy hàng",
            "13" => "Đơn hàng bồi hoàn",
            "20" => "Đang trả hàng (COD cầm hàng đi trả)",
            "21" => "Đã trả hàng (COD đã trả xong hàng)",
            "123" => "Shipper báo đã lấy hàng",
            "127" => "Shipper (nhân viên lấy/giao hàng) báo không lấy được hàng",
            "128" => "Shipper báo delay lấy hàng",
            "45" => "Shipper báo đã giao hàng",
            "49" => "Shipper báo không giao được giao hàng",
            "410" => "Shipper báo delay giao hàng",
        ];
        $this->fail_order_status = [
            '-1',
        ];
        $this->update_order_reason_code = [];
        $this->max_order_value = 20000000;
        $this->picking_status = ['12'];
        $this->picked_status = [
            '3',
            '4'
        ];
        $this->reason_code = [
            100 => 'Nhà cung cấp (NCC) hẹn lấy vào ca tiếp theo',
            101 => 'GHTK không liên lạc được với NCC',
            102 => 'NCC chưa có hàng',
            103 => 'NCC đổi địa chỉ',
            104 => 'NCC hẹn ngày lấy hàng',
            105 => 'GHTK quá tải, không lấy kịp',
            106 => 'Do điều kiện thời tiết, khách quan',
            107 => 'Lý do khác',
            110 => 'Địa chỉ ngoài vùng phục vụ',
            111 => 'Hàng không nhận vận chuyển',
            112 => 'NCC báo hủy',
            113 => 'NCC hoãn/không liên lạc được 3 lần',
            114 => 'Lý do khác',
            115 => 'Đối tác hủy đơn qua API',
            120 => 'GHTK quá tải, giao không kịp',
            121 => 'Người nhận hàng hẹn giao ca tiếp theo',
            122 => 'Không gọi được cho người nhận hàng',
            123 => 'Người nhận hàng hẹn ngày giao',
            124 => 'Người nhận hàng chuyển địa chỉ nhận mới',
            125 => 'Địa chỉ người nhận sai, cần NCC check lại',
            126 => 'Do điều kiện thời tiết, khách quan',
            127 => 'Lý do khác',
            128 => 'Đối tác hẹn thời gian giao hàng',
            129 => 'Không tìm thấy hàng',
            1200 => 'SĐT người nhận sai, cần NCC check lại',
            130 => 'Người nhận không đồng ý nhận sản phẩm',
            131 => 'Không liên lạc được với KH 3 lần',
            132 => 'KH hẹn giao lại quá 3 lần',
            133 => 'Shop báo hủy đơn hàng',
            134 => 'Lý do khác',
            135 => 'Đối tác hủy đơn qua API',
            140 => 'NCC hẹn trả ca sau',
            141 => 'Không liên lạc được với NCC',
            142 => 'NCC không có nhà',
            143 => 'NCC hẹn ngày trả',
            144 => 'Lý do khác',
        ];
        $this->morning_pickup_shift_time = '08:30 - 12:00';
        $this->afternoon_pickup_shift_time = '14:00 - 18:00';
    }
    /**
     * It returns an array of data that is used to create a new order.
     *
     * @param order_id The order ID you want to render.
     */
    public function renderShippingOrderDataFromOrder(int $order_id) {
        $order = Order::with(['pickup_address', 'shipping_address' => function ($q) {
            return $q->with('ward', 'district', 'province');
        }, 'shipping_order'])->findOrFail($order_id);
        $ward_name_arr = explode(" ", $order->shipping_address->ward->name_with_type);
        $ward_name = "";
        $arr = [];
        foreach ($ward_name_arr as $value) {
            $string = convertRomanToInteger($value);
            array_push($arr, $string == 0 ? $value : $string);
        }
        $ward_name = implode(" ", $arr);
        $pickup_shift = $this->getPickupShiftById($order->shipping_order->pickup_shift_id);
        return [
            "order_number" => $order->order_number,
            "products" => self::getOrderItems($order),
            "order" => [
                /* The data that is being sent to the GHTK API to create a new order. */
                /* Creating a unique order ID. */
                "id" => $order->order_number,
                /* The name of the sender. */
                "pick_name" => $order->pickup_address->fullname,
                /* The address of the sender. */
                "pick_address" => $order->pickup_address->details,
                /* The province of the sender. */
                "pick_province" => $order->pickup_address->province->name_with_type,
                /* The district of the sender. */
                "pick_district" => $order->pickup_address->district->name_with_type,
                /* The ward of the sender. */
                "pick_ward" => $order->pickup_address->ward->name_with_type,
                /* The phone number of the sender. */
                "pick_tel" => $order->pickup_address->phone,
                /* Setting the phone number of the receiver. */
                "tel" => $order->shipping_address->phone,
                /* Setting the name of the receiver. */
                "name" => $order->shipping_address->fullname,
                /* Setting the address of the receiver. */
                "address" => $order->shipping_address->details,
                /* Setting the province of the receiver. */
                "province" => $order->shipping_address->province->name_with_type,
                /* Getting the district of the receiver. */
                "district" => $order->shipping_address->district->name_with_type,
                /* Getting the ward of the receiver. */
                "ward" => $ward_name,
                /* A required field. */
                "hamlet" => "Khác",
                /* The order is free shipping. */
                "is_freeship" => $order->is_freeship,
                /* Pickup date. */
                // "pick_date" => "2016-09-30",
                /* The money that the receiver will pay to the sender. */
                "pick_money" => $order->isPaid() ? doubleval(0) :  doubleval($order->total),
                /* Checking if the pickup shift is not null, then it will return the session. */
                "pick_work_shift" => optional($pickup_shift)->session,
                /* Checking if the pickup_shift->date is not empty, if it is not empty, it will format
                the date to Y/m/d. */
                "pick_date" => !empty($pickup_shift->date) ? $pickup_shift->date->format('Y/m/d') : null,
                /* A note that is being sent to the GHTK API. */
                "note" => $order->shipping_order->shipping_time_note,
                /* The value of the order. */
                "value" => doubleval($order->origin_subtotal > $this->max_order_value ? $this->max_order_value : $order->origin_subtotal),
                /* The transport method. */
                "transport" => $order->shipping_order->shipping_service_code,
            ]
        ];
    }
    public function renderShippingOrderDataFromJson(array $data) {
    }
    /**
     * It takes an order object and returns an array of items
     *
     * @param order The order object
     */
    public function getOrderItems($order) {
        $items = [];
        $inventories = $order->inventories()->withTrashed()->with(['product' => function ($q) {
            $q->withTrashed()->select('products.id', 'length', 'width', 'height', 'weight');
        }])->get();
        foreach ($inventories as $item) {
            array_push($items,  [
                "name" => $item->pivot->name,
                "weight" => $item->package_info->weight / 1000,
                "quantity" => $item->pivot->quantity,
                "product_code" => $item->id
            ]);
        }
        return $items;
    }
    /**
     * It cancels an order.
     *
     * @param order_code The order code you want to cancel.
     *
     * @return The response is being returned.
     */
    public function cancelOrder($order_code) {
        $response = $this->post("$this->cancel_order_path/$order_code");
        Log::info("Cancel shipping order on $this->service_slug successful with order code: $order_code");
        return json_decode((string) $response->getBody());
    }
    /**
     * > Get the order with the given code
     *
     * @param code The order code
     *
     * @return The order array.
     */
    public function getOrder($code) {
        $data = parent::getOrder($code);
        return $data ? $data->order : null;
    }
    public function storeShippingOrder($data_after_created_response, $order) {
        $service_order = $this->getOrder($data_after_created_response->order->label);
        $shipping_order = $order->shipping_order;
        if ($service_order) {
            $shipping_order->fill([
                "code" => $service_order->label_id,
                'estimated_pick_time' => Carbon::createFromFormat('Y-m-d', $service_order->pick_date)->format('Y-m-d H:i:s'),
                "estimated_delivery_time" => Carbon::createFromFormat('Y-m-d', $service_order->deliver_date)->format('Y-m-d H:i:s'),
                'status_text' => $service_order->status_text,
                'cod_amount' => $service_order->pick_money,
                "service_fee" => $service_order->ship_money,
                "insurance_fee" => $service_order->insurance,
                "order_value" => $order->total,
                "to_address" => $service_order->address,
                "total_fee" => $service_order->ship_money + $service_order->insurance,
                "order_value" => $order->total,
                "shop_id" => $order->shop_id,
                "order_id" => $order->id,
            ]);
            return $shipping_order->save();
        }
        return null;
    }

    public function post($path, $data = [], $headers = []) {
        $response = parent::post($path, $data, $headers);
        if ($response->getStatusCode() >= 400) {

            Log::error((string) $response->getBody());
            // throw new Exception(json_decode((string) $response->getBody())->message, $response->getStatusCode());
        }
        $data = json_decode((string) $response->getBody());
        if (!$data->success || $data->success === false) {
            throw new Exception($data->message);
        }
        return $response;
    }

    public function get($path, $headers = []) {
        $response = parent::get($path, $headers);
        if ($response->getStatusCode() >= 400) {
            Log::error((string) $response->getBody());
            throw new Exception(json_decode((string) $response->getBody())->message, $response->getStatusCode());
        }
        $data = json_decode((string) $response->getBody());
        if (isset($data) && (!isset($data->success) || $data->success === false)) {
            throw new Exception(json_decode((string) $response->getBody())->message);
        }
        return $response;
    }

    /**
     * It takes a code, makes a request to the API, and returns a PDF if the request was successful
     *
     * @param code The order code
     *
     * @return A PDF file
     */
    public function printOrder($code) {
        $response = $this->get("/services/label/$code");
        return response((string) $response->getBody())->header('Content-Type', 'application/pdf');
    }
    public function pushShippingOrder($order) {
        $order_id = $order->id;
        $result = parent::pushShippingOrder($order);
        ShippingOrder::where('order_id', $order_id)->update(['code' => $result->order->label]);
        return $result->order;
    }
    public function createShippingOrderHistory($data) {
        $order = ShippingOrder::where('code', DB::raw("'" . $data['label_id'] . "'"))->firstOrFail();
        $shipping_order_history_data = new ShippingOrderHistoryData();
        $shipping_order_history_data->shipping_order_id = $order->id;
        $shipping_order_history_data->status = $this->status_string_array[strval($data['status_id'])];
        $shipping_order_history_data->time = $data['action_time'];
        $shipping_order_history_data->description = $data['reason'];
        if (empty($data['reason'])) {
            if (empty($data['reason_code'])) {
                $shipping_order_history_data->reason = $this->status_string_array[strval($data['status_id'])];
            } else {
                $shipping_order_history_data->reason = $this->reason_code['reason_code'];
            }
        } else {
            $shipping_order_history_data->reason = $data['reason'];
        }
        $shipping_order_history_data->fee = $data['fee'];
        $shipping_order_history_data->cod_amount = $data['pick_money'];
        $shipping_order_history_data->status_code = $data['status_id'];
        parent::createShippingOrderHistory($shipping_order_history_data);
    }
    public function getShipServices(Address $shipping_address) {
        // if($shipping_address->ward->support_type != 0) {
        $services = new stdClass();
        $services->data = [
            (object) array(
                'service_id' => 'road',
                'shipping_service_code' => 'road',
                'short_name' => ShippingServiceType::STANDARD_SHIPPING_SERVICE_NAME,
                'service_type_id' => ShippingServiceType::STANDARD_SHIPPING_SERVICE_CODE
            )
        ];
        // if ($this->config->pickup_address->province->domain_code != $shipping_address->province->domain_code)
        //     array_push($services->data, (object) array(
        //         'service_id' => 'fly',
        //         'shipping_service_code' => 'fly',
        //         'short_name' => ShippingServiceType::FAST_SHIPPING_SERVICE_NAME,
        //         'service_type_id' => ShippingServiceType::FAST_SHIPPING_SERVICE_CODE
        //     ));
        return $services->data;
        // }
        return [];
    }

    public function getShipServiceNameById($id) {
        return self::SHIP_SERVICE_LIST[$id];
    }


    public function estimatePickTime() {
        $now = Carbon::now();
        /* Checking if the current time is less than 10:30am. */
        if ($now < Carbon::createFromTime(10, 30)) {
            $title = "Ca lấy " . $now->format('d-m-Y') . " ($this->morning_pickup_shift_time)";
            $id = 1;
            /* Checking if the current time is less than 4pm. */
        } else if ($now < Carbon::createFromTime(16, 0)) {
            $title = "Ca lấy " . $now->format('d-m-Y') . " ($this->morning_pickup_shift_time)";
            $id = 2;
        } else {
            $title = "Trước " . Carbon::createFromTime(12, 0)->addDays(1) . " ($this->morning_pickup_shift_time)";
            $id = 3;
        }
        return new PickupShift($title, $id);
    }
    public function getListPickupTime() {
        $now = now();
        $pickup_shifts = [];
        /* Checking if the current time is less than 10:30am. */
        if ($now < Carbon::createFromTime(10, 30)) {
            $morning_shift = $this->getPickupShiftById(self::MORNING_PICKUP_SHIFT_CODE);
            $afternoon_shift = $this->getPickupShiftById(self::AFTERNOON_PICKUP_SHIFT_CODE);
            $tomorrow_moring_shift = $this->getPickupShiftById(self::TOMORROW_MORNING_PICKUP_SHIFT_CODE);
            $pickup_shifts = [$morning_shift, $afternoon_shift, $tomorrow_moring_shift];
            /* Checking if the current time is less than 4pm. */
        } else if ($now < Carbon::createFromTime(16, 0)) {
            $afternoon_shift = $this->getPickupShiftById(self::AFTERNOON_PICKUP_SHIFT_CODE);
            $tomorrow_moring_shift = $this->getPickupShiftById(self::TOMORROW_MORNING_PICKUP_SHIFT_CODE);
            $tomorrow_afternoon_shift = $this->getPickupShiftById(self::TOMORROW_AFTERNOON_PICKUP_SHIFT_CODE);
            $pickup_shifts = [$afternoon_shift, $tomorrow_moring_shift, $tomorrow_afternoon_shift];
        } else {
            $tomorrow_moring_shift = $this->getPickupShiftById(self::TOMORROW_MORNING_PICKUP_SHIFT_CODE);
            $tomorrow_afternoon_shift = $this->getPickupShiftById(self::TOMORROW_AFTERNOON_PICKUP_SHIFT_CODE);
            $the_morning_of_the_day_after_tomorrow_shift = $this->getPickupShiftById(self::THE_MORNING_OF_THE_DAY_AFTER_TOMORROW_PICKUP_SHIFT_CODE);
            $pickup_shifts = [$tomorrow_moring_shift, $tomorrow_afternoon_shift, $the_morning_of_the_day_after_tomorrow_shift];
        }
        return $pickup_shifts;
    }
    public function calculateDeliveryFee($data) {
        $new_data = [
            "pick_province" => $this->config->pickup_address->province->name,
            "pick_district" => $this->config->pickup_address->district->name_with_type,
            "province" => $data->shipping_address->province->name,
            "district" => $data->shipping_address->district->name_with_type,
            "address" => $data->shipping_address->address_line_1,
            "weight" => $data->weight,
            "value" => $data->total_value,
            "transport" => $data->service_id
        ];
        $data = parent::calculateDeliveryFee($new_data)->fee;
        return new DeliveryFeeResponseData($data->fee, $data->ship_fee_only, $data->insurance_fee);
    }
    public function get_route_code($shipping_address) {
        if ($this->config->pickup_address->province->id == $shipping_address->province->id)
            return self::INNER_CITY_ROUTE_CODE;
        if ($this->config->pickup_address->province->domain_code == $shipping_address->province->domain_code)
            return self::INNER_DOMAIN_ROUTE_CODE;
        if (in_array($this->config->pickup_address->province->name, self::SPECIAL_PROVINCES))
            return self::SPECIAL_ROUTE_CODE;
        return self::OUTER_DOMAIN_ROUTE_CODE;
    }
    public function calculateDeliveryTime($data) {
        $shipping_address = $data->shipping_address;
        $route_code = self::get_route_code($shipping_address);
        switch ($route_code) {
            case self::INNER_CITY_ROUTE_CODE:
                return Carbon::now()->addHours(self::PICKUP_TIME_ESTIMATE + self::INNER_CITY_ROUTE_DELIVERY_HOURS);
            case self::INNER_DOMAIN_ROUTE_CODE;
                return Carbon::now()->addHours(self::PICKUP_TIME_ESTIMATE + self::INNER_DOMAIN_ROUTE_DELIVERY_HOURS);
            case self::SPECIAL_ROUTE_CODE:
                $hours = current(array_filter(self::SPECIAL_ROUTE_DELIVERY_HOURS, function ($delivery_hour) use ($data) {
                    return $delivery_hour['service_type_id'] == $data->service_type_id;
                }))['delivery_time'];
                return Carbon::now()->addHours(self::PICKUP_TIME_ESTIMATE + $hours);
            default:
                $hours = current(array_filter(self::OUTER_DOMAIN_ROUTE_DELIVERY_HOURS, function ($delivery_hour) use ($data) {
                    return $delivery_hour['service_type_id'] == $data->service_type_id;
                }))['delivery_time'];
                return Carbon::now()->addHours(self::PICKUP_TIME_ESTIMATE + $hours);
        }
    }


}
