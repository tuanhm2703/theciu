<?php

namespace App\Models;

use App\Enums\AddressType;
use App\Interfaces\AppConfig;
use App\Traits\Common\Addressable;
use App\Traits\Common\Metable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Meta;
use Spatie\SchemaOrg\ContactPoint;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\SearchAction;

class Config extends Model {
    use HasFactory, Metable, Addressable;

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
        if ($meta_tag) {
            app()->bind('organization_schema', function() use ($meta_tag) {
                $schemas = [];
                $payload = $meta_tag->payload;
                $schemas[] = Schema::webSite()->url(url(''))->potentialAction((new SearchAction())->target(route('admin.product.index') . "?keyword={search_item}")->setProperty('query-input', 'required name=search_item'))->toScript();
                $schemas[] = Schema::organization()
                                    ->url(url(''))
                                    ->name($payload['title'])
                                    ->sameAs([
                                        'https://www.facebook.com/The.C.I.U.2016/',
                                        'https://www.instagram.com/theciusaigon/',
                                        'https://www.tiktok.com/@theciusaigon'
                                    ])
                                    ->contactPoint(Schema::contactPoint()->email('cskh@theciu.vn'))->toScript();
                $schemas[] = Schema::organization()->url(url(''))->logo(asset('/img/apple-touch-icon.png'))->toScript();
                $branches = Branch::all();
                $organization3 = Schema::organization()->url(url(''))->logo(asset('/img/apple-touch-icon.png'));
                $contactPoints = [];
                foreach ($branches as $branch) {
                    $contactPoints[] = (new ContactPoint())->telephone($branch->phone)->areaServed('VN')->availableLanguage('VN')->contactType('sale');
                }
                $schemas[] = $organization3->contactPoints($contactPoints)->toScript();
                return $schemas;
            });
            foreach ($meta_tag->payload as $key => $content) {
                Meta::set($key, $content);
            }
        } else {
            app()->bind('organization_schema', function() {
                return [];
            });
        }
        Meta::set('image', asset('img/theciu-meta.png'));
    }
}
