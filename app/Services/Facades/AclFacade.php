<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class AclFacade extends Facade {

    public static function getFacadeAccessor() {
        return 'Acl';
    }

}
