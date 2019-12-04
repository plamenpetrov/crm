<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class PersonsFacade extends Facade {

    public static function getFacadeAccessor() {
        return 'persons';
    }

}
