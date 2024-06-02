<?php

namespace App\Traits\Common;

use App\Models\Tag;

trait Taggable {
    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function tag() {
        return $this->morphToOne(Tag::class, 'taggable');
    }

    public function getTagArray() {
        return $this->tags()->select('tags.id as id', 'tags.name as text')->pluck('text', 'id')->toArray();
    }

    public function addTags(array $tags) {
        $this->tags()->sync([], false);
        foreach ($tags as $tag) {
            $this->tags()->firstOrCreate([
                'tags.id' => $tag
            ], [
                'name' => $tag
            ]);
        }
    }
}
