<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class EventsFacade extends Facade {

    public static function getFacadeAccessor() {
        return 'myevents';
    }

}
