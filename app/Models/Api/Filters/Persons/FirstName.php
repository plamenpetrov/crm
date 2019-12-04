<?php

namespace App\Models\Api\Filters\Persons;

use Illuminate\Database\Eloquent\Builder;
use \App\Models\Api\Filters\FilterInterface as Filter;

class FirstName implements Filter
{

    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('first_name', 'LIKE', '%' . $value . '%');
    }
}