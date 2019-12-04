<?php

namespace App\Models\Api\Filters\Contragents;

use \App\Models\Api\Filters\Search as Search;

class SearchContragent extends Search {

    public static function createFilterDecorator($name) {
        return __NAMESPACE__ . '\\' . studly_case($name);
    }

}
