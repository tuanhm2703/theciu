<?php

namespace App\Traits\Common;

use App\Models\MetaTag;
use Meta;

trait Metable
{
    public function metaTag()
    {
        return $this->morphOne(MetaTag::class, 'metable');
    }

    public function metaTags()
    {
        return $this->morphMany(MetaTag::class, 'metable');
    }

    public function syncMetaTag($payload)
    {
        $this->metaTags()->updateOrCreate([
            'metable_id' => $this->id,
            'metable_type' => $this->getMorphClass()
        ], [
            'payload' => $payload
        ]);
    }

    public function loadMeta()
    {
        $meta_tag = $this->metaTag;
        if ($meta_tag) {
            foreach ($meta_tag->payload as $key => $content) {
                if($content) {
                    Meta::set($key, $content);
                }
            }
        }
    }
}
