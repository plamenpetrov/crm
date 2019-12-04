<?php

namespace App\Models\Api\Filters\Events;

use \App\Models\Api\Filters\Search as Search;

class SearchEvent extends Search {

    public static function createFilterDecorator($name) {
        return __NAMESPACE__ . '\\' . studly_case($name);
    }

}
