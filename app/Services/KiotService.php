<?php

namespace App\Services;

use App\Jobs\Kiot\SyncKiotCustomerJob;
use Illuminate\Http\Request;
use App\Enums\PaymentMethodType;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\KiotCustomer;
use App\Models\KiotInvoice;
use App\Models\KiotProduct;
use App\Models\Order;
use App\Models\Rank;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Exception\KiotVietException;
use VienThuong\KiotVietClient\Model\Customer as ModelCustomer;
use VienThuong\KiotVietClient\Model\Invoice;
use VienThuong\KiotVietClient\Model\Order as ModelOrder;
use VienThuong\KiotVietClient\Resource\CustomerResource;
use VienThuong\KiotVietClient\Resource\InvoiceResource;
use VienThuong\KiotVietClient\Resource\OrderResource;
use VienThuong\KiotVietClient\WebhookType;
use VienThuong\KiotVietClient\Model\Customer as KiotCus;

class KiotService {
    public static function updateCustomerRank(Customer $customer) {
        // if($customer->available_rank && $customer->kiot_customer)
    }

    public static function syncKiotInfo(Customer $customer) {
        $customerResource = new CustomerResource(App::make(Client::class));
        if ($customer->phone) {
            try {
                $info = $customerResource->list(['contactNumber' => $customer->phone, 'includeCustomerGroup' => true])->toArray();
                if (count($info) > 0) {
                    $info = $info[0];
                    $customer->kiot_customer()->updateOrCreate([
                        'code' => $info['code'],
                        'kiot_customer_id' => $info['id']
                    ], [
                        'total_point' => $info['totalPoint'],
                        'reward_point' => $info['rewardPoint'],
                        'data' => json_encode($info)
                    ]);
                    $rank_names = explode('|', $info['groups']);
                    $rank = Rank::whereIn('name', $rank_names)->orderBy('min_value', 'desc')->first();
                    if ($rank) {
                        if ($customer->available_rank && $customer->available_rank->min_value < $rank->min_value) {
                            $customer->ranks()->sync($rank->id);
                        } else if (!$customer->available_rank) {
                            $customer->ranks()->sync($rank->id);
                        }
                    } else {
                        if ($customer->available_rank && $customer->available_rank->pivot->value == 0) {
                            $customer->available_ranks()->where('customer_ranks.value', 0)->detach();
                        }
                        $customer->kiot_customer()->delete();
                    }
                    return true;
                } else {
                    $customer->available_ranks()->where('customer_ranks.value', 0)->detach();
                }
            } catch (\Throwable $th) {
                Log::channel('kiot')->error($th);
            }
        }
        return false;
    }

    public function saveKiotCustomerByIdId($id) {
        try {
            $customerResource = new CustomerResource(App::make(Client::class));
            $kiotCustomer = $customerResource->getById($id);
            $customer = Customer::wherePhone($kiotCustomer->getContactNumber())->first();
            $this->saveKiotCustomerToLocal($customer, $kiotCustomer);
            return true;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return false;
    }

    public function saveKiotCustomerToLocal(Customer $customer = null, KiotCus $kiotCustomer) {
        return KiotCustomer::updateOrCreate([
            'code' => $kiotCustomer->getCode()
        ], [
            'customer_id' => $customer?->id,
            'kiot_customer_id' => $kiotCustomer->getId(),
            'total_point' => $kiotCustomer->getTotalPoint(),
            'reward_point' => $kiotCustomer->getRewardPoint(),
            'contact_number' => $kiotCustomer->getContactNumber(),
            'data' => $kiotCustomer->getModelData()
        ]);
    }

    public function syncKiotCustomerLocally(Customer $customer, KiotCustomer $kiotCustomer) {
        $info = $kiotCustomer->data;
        $kiotCustomer->update([
            'total_point' => $kiotCustomer->total_point,
            'reward_point' => $kiotCustomer->reward_point,
        ]);
        if ($info['groups'] != null) {
            $rank_names = explode('|', $info['groups']);
            $rank = Rank::whereIn('name', $rank_names)->orderBy('min_value', 'desc')->first();
            if ($rank) {
                if ($customer->available_rank && $customer->available_rank->min_value < $rank->min_value) {
                    $customer->ranks()->sync($rank->id);
                } else if (!$customer->available_rank) {
                    $customer->ranks()->sync($rank->id);
                }
            } else {
                if ($customer->available_rank && $customer->available_rank->pivot->value == 0) {
                    $customer->available_ranks()->where('customer_ranks.value', 0)->detach();
                }
                $customer->kiot_customer()->delete();
            }
        } else {
            $customer->ranks()->delete();
        }
    }

    public static function cancelKiotInvoice(Order $order) {
        if ($order->kiot_invoice) {
            $order->kiot_invoice->removeKiotInvoice();
            return true;
        }
        return false;
    }

    public static function cancelKiotOrder(Order $order, $cancelInvoice = true) {

        $kiot_order = $order->kiot_order;
        if ($kiot_order) {
            try {
                $orderResource = new OrderResource(App::make(Client::class));
                $invoiceResource = new InvoiceResource(App::make(Client::class));
                $order = $orderResource->getByCode($kiot_order->kiot_code);
                if ($order->getOtherProperties()) {
                    $data = $order->getOtherProperties();
                    if (isset($data['invoices']) && count($data['invoices']) > 0) {
                        $invoice = $data['invoices'][0];
                        $invoiceResource->remove($invoice['invoiceId']);
                    }
                };
                $orderResource->remove($order->getId());
                return true;
            } catch (\Throwable $th) {
                Log::channel('kiot')->error($th);
            }
        }
        return false;
    }

    public static function getOrderById($id) {
        $orderResource = new OrderResource(App::make(Client::class));
        try {
            return $orderResource->getById($id);
        } catch (\Throwable $th) {
            Log::channel('kiot')->error($th);
            return null;
        }
    }

    public static function createKiotInvoice(Order $localOrder) {
        try {
            $discount = $localOrder->order_voucher ? $localOrder->order_voucher->pivot->amount + $localOrder->combo_discount : $localOrder->combo_discount;
            $discount += $localOrder->additional_discount;
            $kiotCustomer = new ModelCustomer([
                'name' => $localOrder->shipping_address->fullname,
                'gender' => false,
                "contactNumber" => $localOrder->shipping_address->phone,
                'address' => $localOrder->shipping_address->full_address
            ]);
            if (!$localOrder->kiot_order) {
                try {
                    $order = static::createKiotOrder($localOrder);
                } catch (\Throwable $th) {
                    Log::channel('kiot')->error($th);
                    $order = false;
                }
            } else {
                $order = static::getOrderById($localOrder->kiot_order->kiot_order_id);
            }
            if ($order) {
                $order->setDiscount($discount);
                $order->setMakeInvoice(true);
                $order->setCustomer($kiotCustomer);
                $order->setTotalPayment($localOrder->total - $localOrder->customer_shipping_fee_amount);
                $orderResource = new OrderResource(App::make(Client::class));
                $orderResource->update($order);
            } else {
                return false;
            }
            return true;
        } catch (\Throwable $th) {
            Log::channel('kiot')->error($th);
        }
        return false;
    }

    public static function createKiotOrder(Order $localOrder) {
        $orderResource = new OrderResource(App::make(Client::class));
        $kiotSetting = App::get('KiotConfig');
        $order = new ModelOrder();
        $kiotCustomer = new ModelCustomer([
            'name' => $localOrder->shipping_address->fullname,
            'gender' => false,
            "contactNumber" => $localOrder->shipping_address->phone,
            'address' => $localOrder->shipping_address->full_address
        ]);
        $discount = $localOrder->order_voucher ? $localOrder->order_voucher->pivot->amount + $localOrder->combo_discount : $localOrder->combo_discount;
        $discount += $localOrder->additional_discount;
        $order->setIsApplyVoucher($localOrder->order_voucher ? true : false);
        $order->setBranchId($kiotSetting->data['branchId']);
        $order->setDiscount($discount);
        $order->setDescription("The C.I.U Order: $localOrder->order_number");
        $order->setMethod(PaymentMethodType::getKiotMethodType($localOrder->payment_method->type));
        $order->setSoldById($kiotSetting->data['salerId']);
        $order->setSaleChannelId(isset($kiotSetting->data['saleChannelId']) ? $kiotSetting->data['saleChannelId'] : null);
        $order->setMakeInvoice(false);
        $order->setMethod(PaymentMethodType::getKiotMethodType($localOrder->payment_method->type));
        $order->setOrderDetails($localOrder->generateKiotOrderDetailCollection());
        $order->setCustomer($kiotCustomer);
        if (isset($kiotSetting->data['saleId'])) {
            $order->setSoldById($kiotSetting->data['saleId']);
        }
        try {
            $kiotOrder = $orderResource->create($order, [
                'Partner' => 'KVSync'
            ]);
            $localOrder->kiot_order()->create([
                'kiot_order_id' => $kiotOrder->getId(),
                'kiot_code' => $kiotOrder->getCode(),
                'data' => $kiotOrder->getModelData()
            ]);
            return $kiotOrder;
        } catch (KiotVietException $th) {
            throw $th;
        }
    }

    public function syncWarehouseThroughWebhook(Request $request) {
        $data = $request->Notifications[0]['Data'][0];
        if (isset($request->Notifications[0]["Action"]) && (strpos($request->Notifications[0]["Action"], WebhookType::PRODUCT_DELETE) > -1)) {
            $codes = $request->Notifications[0]['Data'];
            $skus = KiotProduct::whereIn('kiot_product_id', $codes)->pluck('kiot_code')->toArray();
            Inventory::whereIn('sku', $skus)->delete();
        } else {
            $sku = $data['ProductCode'];
            $inventory = Inventory::whereSku($sku)->firstOrFail();
            $kiotConfig = App::get('KiotConfig');
            if ($inventory->sku == $sku && $kiotConfig->data['branchId'] == $data['BranchId']) {
                $inventory->stock_quantity = $data['OnHand'] - $data['Reserved'];
                $inventory->stock_quantity = $inventory->stock_quantity < 0 ? 0 : $inventory->stock_quantity;
                $inventory->status = $data['isActive'];
                $inventory->save();
            }
        }
    }

    public function migrateSyncCustomers() {
        $customerResource = new CustomerResource(App::make(Client::class));
        $pageSize = 100;
        $total = $customerResource->list(['pageSize' => 1])->getTotal();
        $numberOfPages = $total % $pageSize === 0 ? $total / $pageSize : floor(($total / $pageSize)) + 1;
        $currentItem = 0;
        $pageSize += 1;
        for ($i = 0; $i < $numberOfPages; $i++) {
            dispatch(new SyncKiotCustomerJob($currentItem, $pageSize));
            $currentItem += $pageSize;
        }
    }

    public function syncAllLocalCustomerWithKiot() {
        $customers = Customer::with(['kiot_customer_by_phone'])->get();
        foreach ($customers as $customer) {
            try {
                $kiotCustomer = $customer->kiot_customer_by_phone;
                if ($kiotCustomer) {
                    $this->syncKiotCustomerLocally($customer, $kiotCustomer);
                }
            } catch (\Throwable $th) {
                continue;
            }
        }
    }
}
