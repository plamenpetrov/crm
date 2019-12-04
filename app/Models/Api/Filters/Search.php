<?php

namespace App\Models\Api\Filters;

use Illuminate\Http\Request as Request;

abstract class Search {

    /**
     * Aplly requested filters to given query to perform search functionality 
     * @param Request $filters
     * @param type $query
     * @return type
     */
    public static function apply(Request $filters, $query) {
        return static::applyDecoratorsFromRequest($filters, $query);
    }

    /**
     * Use decorator to create filters on given query
     * @param Request $request
     * @param type $query
     * @return type
     */
    private static function applyDecoratorsFromRequest(Request $request, $query) {
        if ($request->input('filters') !== null) {
//            $request->merge(['page' => 1]);

            foreach ($request->input('filters') as $filterName => $value) {
                $decorator = static::createFilterDecorator($filterName);

                if (static::isValidDecorator($decorator) && $value) {
                    $query = $decorator::apply($query, $value);
                }
            }
        }

        $field = $request->input('sortby') != '' ? $request->input('sortby') : 'id';
        $sort = $request->input('sort') != '' ? $request->input('sort') : 'asc';

        $query->orderBy($field, $sort);

        return $query;
    }

    /**
     * Check if given name is valid decorator
     * @param type $decorator
     * @return type
     */
    private static function isValidDecorator($decorator) {
        return class_exists($decorator);
    }

    /**
     * Execute query
     * @param type $query
     * @return type
     */
    private static function getResults($query) {
        return $query->get();
    }

}
