<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'data'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    public static function getKiotSetting() {
        return Setting::firstOrCreate([
            'name' => 'kiotviet_config'
        ], [
            'data' => [
                'branchId' => null
            ]
        ]);
    }
}
