<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class ResponseApiFacade extends Facade {

    public static function getFacadeAccessor() {
        return 'ResponseApi';
    }

}
