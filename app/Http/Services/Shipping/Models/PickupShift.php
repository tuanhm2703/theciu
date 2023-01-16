<?php

namespace App\Http\Services\Shipping\Models;

use Carbon\Carbon;

class PickupShift {
    public $time;
    public $id;
    public $date;
    public $soonest;
    public $latest;
    public $latest_pickup_time = null;
    public $session = null;
    const MORNING = 1;
    const AFTERNOON = 2;
    public function __construct($time, $id, $date = null, $soonest = null, $latest = null) {
        $this->time = $time;
        $this->id = $id;
        $this->date =  $date != null ? Carbon::createFromFormat('d-m-Y', $date) : null;
        $this->soonest = $soonest;
        $this->latest = $latest;
        if ($date != null && $latest != null) $this->latest_pickup_time = Carbon::createFromFormat('d-m-Y H:i', "$date $latest");
        if($latest != null) {
            if($latest <= "12:00") $this->session = self::MORNING;
            else $this->session = self::AFTERNOON;
        }
    }
}
