<?php

namespace App\Observers;

use App\Models\Jd;

class JdObserver
{
    public function creating(Jd $jd) {
        $jd->slug = stripVN($jd->name);
        while (Jd::whereSlug($jd->slug)->exists()) {
            $jd->slug = stripVN($jd->name);
            $code = uniqid();
            $jd->slug = $jd->slug . "-" . $code;
        }
    }

    public function updating(Jd $jd) {
        $jd->slug = stripVN($jd->name);
        while (Jd::whereSlug($jd->slug)->exists()) {
            $jd->slug = stripVN($jd->name);
            $code = uniqid();
            $jd->slug = $jd->slug . "-" . $code;
        }
    }
}