<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Rank;
use Illuminate\Support\Facades\App;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\CustomerResource;

class KiotService
{
    public static function updateCustomerRank(Customer $customer)
    {
        // if($customer->available_rank && $customer->kiot_customer)
    }

    public function syncKiotInfo(Customer $customer)
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
                        }
                    } else {
                        if ($customer->available_rank && $customer->available_rank->pivot->value == 0) {
                            $customer->available_ranks()->where('customer_ranks.value', 0)->detach();
                        }
                    }
                    return true;
                } else {
                    $customer->available_ranks()->where('customer_ranks.value', 0)->detach();
                }
            } catch (\Throwable $th) {
                \Log::info($th);
            }
        }
        return false;
    }
}
