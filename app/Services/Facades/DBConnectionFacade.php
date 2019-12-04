<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class DBConnectionFacade extends Facade {

    public static function getFacadeAccessor() {
        return 'DBConnection';
    }

}
