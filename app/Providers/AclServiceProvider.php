<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use App\Services\Acl\Acl as Acl;

class AclServiceProvider extends LaravelServiceProvider {

    public function register() {
        $this->app->singleton('Acl', function ($app) {
            return new Acl();
        });
    }

}
