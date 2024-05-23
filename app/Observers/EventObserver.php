<?php

namespace App\Observers;

use App\Models\Event;

class EventObserver
{
    public function creating(Event $event) {
        $event->slug = $event->generateUniqueSlug();
    }


    public function updating(Event $event) {
        if($event->isDirty('name')) {
            $event->slug = $event->generateUniqueSlug();
        }
    }
}
