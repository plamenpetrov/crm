<?php

namespace App\Models\Api\Filters\Users;

use \App\Models\Api\Filters\Search as Search;

class SearchUser extends Search {

    public static function createFilterDecorator($name) {
        return __NAMESPACE__ . '\\' . studly_case($name);
    }

}
