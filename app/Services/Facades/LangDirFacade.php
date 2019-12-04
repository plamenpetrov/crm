<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class LangDirFacade extends Facade {

    public static function getFacadeAccessor() {
        return 'LangDir';
    }

}
