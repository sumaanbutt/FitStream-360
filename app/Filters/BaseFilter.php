<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class BaseFilter
{
    protected Builder $builder;

    protected Request $request;

    protected string $defaultSort = 'created_at';

    protected string $defaultDirection = 'desc';

    protected int $defaultLimit = 10;

    public function __construct(?Request $request = null)
    {
        $this->request = $request ?? request();
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        $this->applyFilters();

        return $this->process();
    }

    protected function applyFilters(): void
    {
        foreach ($this->request->query() as $filter => $value) {

            if (
                $value === null ||
                $value === ''
            ) {
                continue;
            }

            $method = Str::camel($filter);

            if (method_exists($this, $method)) {

                $this->{$method}($value);

            }
        }
    }

    protected function select(): void
    {
        if (
            !$this->request->filled('select')
        ) {
            return;
        }

        $columns = array_map(
            'trim',
            explode(',', $this->request->input('select'))
        );

        $this->builder->select($columns);
    }

    protected function sort(): void
    {
        $column = $this->request->input(
            'sort',
            $this->defaultSort
        );

        $direction = strtolower(
            $this->request->input(
                'direction',
                $this->defaultDirection
            )
        );

        if (
            !in_array($direction, [
                'asc',
                'desc',
            ])
        ) {
            $direction = $this->defaultDirection;
        }

        $this->builder->orderBy(
            $column,
            $direction
        );
    }

    protected function process()
    {
        $this->select();

        $this->sort();

        $category = $this->request->input(
            'data_category',
            'paginate'
        );

        return match ($category) {

            'list' => $this->builder->get(),

            'stats' => [
                'total' => $this->builder->count(),
            ],

            default => $this->builder->paginate(
                $this->request->integer(
                    'limit',
                    $this->defaultLimit
                )
            ),

        };
    }
}
