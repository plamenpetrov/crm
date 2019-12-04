<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class UsersFacade extends Facade {

    public static function getFacadeAccessor() {
        return 'myusers';
    }

}
