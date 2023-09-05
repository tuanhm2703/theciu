<?php

namespace App\Traits\Scopes;

use App\Enums\StatusType;

trait CustomScope {
    public function scopeSearch($query, $column, $value, $mode = '') {
        if ($value == null || $value == '') return $query;
        return $query->where(function ($q) use ($column, $value, $mode) {
            $q->whereRaw("lower($column) like $mode ".'"'.$value.'"')
                ->orWhereRaw("lower($column) like $mode ".'"'.$value.'%"')
                ->orWhereRaw("lower($column) like $mode ".'"%'.$value.'%"')
                ->orWhereRaw("lower($column) like $mode ".'"%'.$value.'"');
        });
    }

    public function scopeGetPage($q, $page, $pageSize, $total = false) {
        if(!$total) {
            $q->skip(($page - 1) * $pageSize);
        }
        return $q->take($pageSize);
    }

    public function scopeOrderByField($q, $field, array $value, $mode = 'asc') {
        $str = implode(',', $value);
        return $q->orderByRaw("FIELD($field, $str) $mode");
    }

    public function scopeActive($q) {
        return $q->where('status', StatusType::ACTIVE);
    }
}
