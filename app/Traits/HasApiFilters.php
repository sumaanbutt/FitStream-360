<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasApiFilters
{
    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        foreach ($filters as $field => $value) {

            if ($value === null || $value === '') {
                continue;
            }

            if ($field === 'sort') {
                $this->applySorting($query, $value, $filters);
                continue;
            }

            if (!in_array($field, $this->filterable ?? [])) {
                continue;
            }

            $method = 'filter' . str($field)->studly();

            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
            } else {
                $query->where($field, $value);
            }
        }

        return $query;
    }

    protected function applySorting(Builder $query, string $column, array $filters): void
    {
        if (!in_array($column, $this->sortable ?? [])) {
            return;
        }

        $direction = strtolower($filters['direction'] ?? 'asc');

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $query->orderBy($column, $direction);
    }
}
