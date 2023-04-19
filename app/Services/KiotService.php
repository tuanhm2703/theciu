<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\KiotInvoice;
use App\Models\Order;
use App\Models\Rank;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Model\Customer as ModelCustomer;
use VienThuong\KiotVietClient\Model\Invoice;
use VienThuong\KiotVietClient\Model\Order as ModelOrder;
use VienThuong\KiotVietClient\Resource\CustomerResource;
use VienThuong\KiotVietClient\Resource\InvoiceResource;
use VienThuong\KiotVietClient\Resource\OrderResource;

class KiotService
{
    public static function updateCustomerRank(Customer $customer)
    {
        // if($customer->available_rank && $customer->kiot_customer)
    }

    public static function syncKiotInfo(Customer $customer)
    {
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
                    ]);
                    $rank_names = explode('|', $info['groups']);
                    $rank = Rank::whereIn('name', $rank_names)->orderBy('min_value', 'desc')->first();
                    if ($rank) {
                        if ($customer->available_rank && $customer->available_rank->min_value < $rank->min_value) {
                            $customer->ranks()->sync($rank->id);
                        } else if(!$customer->available_rank) {
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
                Log::info($th);
            }
        }
        return false;
    }

    public static function cancelKiotInvoice(Order $order) {
        if($order->kiot_invoice) {
            $order->kiot_invoice->removeKiotInvoice();
            return true;
        }
        return false;
    }

    public static function cancelKiotOrder(Order $order, $cancelInvoice = true) {
        $kiot_order = $order->kiot_order;
        if($kiot_order) {
            $orderResource = new OrderResource(App::make(Client::class));
            try {
                $orderResource->remove("$kiot_order->kiot_order_id?IsVoidPayment=$cancelInvoice");
                return true;
            } catch (\Throwable $th) {
                Log::error($th);
            }
        }
        return false;
    }

    public static function createKiotInvoice(ModelOrder $order, Order $localOrder)
    {
        try {
            $invoice = new Invoice([
                'branchId' => $order->getBranchId(),
                'purchaseDate' => (string) now(),
                'customerId' => $order->getCustomerId(),
                'discount' => $order->getDiscount(),
                'totalPayment' => $order->getTotalPayment(),
                'saleChannelId' => $order->getSaleChannelId(),
                'method' => 'test',
                'usingCod' => false,
                'soldById' => 422903,
                'orderId' => $order->getId(),
                'invoiceDetails' => $localOrder->generateKiotInvoiceDetailCollection(),
                'status' => 3
            ]);
            $invoiceResource = new InvoiceResource(App::make(Client::class));
            $kiotInvoice = $invoiceResource->create($invoice);
            KiotInvoice::create([
                'kiot_invoice_id' => $kiotInvoice->getId(),
                'kiot_code' => $kiotInvoice->getCode(),
                'data' => $kiotInvoice->getModelData(),
                'kiot_order_code' => $order->getCode(),
                'order_id' => $localOrder->id
            ]);
            return true;
        } catch (\Throwable $th) {
            Log::error($th);
        }
        return false;
    }

    public static function createKiotOrder(Order $localOrder)
    {
        try {
            $orderResource = new OrderResource(App::make(Client::class));
            $kiotSetting = App::get('KiotConfig');
            $order = new ModelOrder();
            $order->setBranchId($kiotSetting->data['branchId']);
            $order->setDescription("The C.I.U Order: $localOrder->order_number");
            $order->setTotalPayment($localOrder->total);
            $order->setMethod('hello');
            $order->setSaleChannelId(isset($kiotSetting->data['saleChannelId']) ? $kiotSetting->data['saleChannelId'] : null);
            $order->setMakeInvoice(false);
            $order->setOrderDetails($localOrder->generateKiotOrderDetailCollection());
            if(isset($kiotSetting->data['saleId'])) {
                $order->setSoldById($kiotSetting->data['saleId']);
            }
            $kiotOrder = $orderResource->create($order, [
                'Partner' => 'KVSync'
            ]);
            $localOrder->kiot_order()->create([
                'kiot_order_id' => $kiotOrder->getId(),
                'kiot_code' => $kiotOrder->getCode(),
                'data' => $kiotOrder->getModelData()
            ]);
            static::createKiotInvoice($kiotOrder, $localOrder);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
        return true;
    }
}
