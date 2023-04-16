<?php

namespace App\Models;

use App\Enums\AddressType;
use App\Interfaces\AppConfig;
use App\Traits\Common\Metable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Meta;

class Config extends Model {
    use HasFactory, Metable;
    public function pickup_address() {
        return $this->morphOne(Address::class, 'addressable')->where('type', AddressType::PICKUP);
    }
    public function pickup_addresses() {
        return $this->morphMany(Address::class, 'addressable')->where('type', AddressType::PICKUP);
    }

    public static function loadMeta() {
        $config = App::get('AppConfig');
        $meta_tag = $config->metaTag()->firstOrCreate([
            'metable_id' => $config->id,
            'metable_type' => $config->getMorphClass()
        ], [
            'payload' => [
                'title' => config('meta.default_title'),
                'description' => config('meta.default_description'),
                'keywords' => config('meta.default_title'),
            ]
        ]);
        if($meta_tag) {
            foreach ($meta_tag->payload as $key => $content) {
                Meta::set($key, $content);
            }
        }
    }
}
