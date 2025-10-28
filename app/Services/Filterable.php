<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilters(Builder $query, array $filters = []): Builder
    {
        if (empty($filters)) {
            $filters = request()->query();
        }
        foreach ($filters as $key => $value) {
            if (method_exists($this, 'scope' . ucfirst($key))) {
                if (!empty($value)) {
                    $query->$key($value);
                }
            }
        }
        return $query;
    }
}
