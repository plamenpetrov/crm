<?php

namespace App\Models\Api\Filters\Persons;

use \App\Models\Api\Filters\Search as Search;

class SearchPerson extends Search {

    public static function createFilterDecorator($name) {
        return __NAMESPACE__ . '\\' . studly_case($name);
    }

}
