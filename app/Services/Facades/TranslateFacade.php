<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class TranslateFacade extends Facade {

    public static function getFacadeAccessor() {
        return 'Translate';
    }

}
