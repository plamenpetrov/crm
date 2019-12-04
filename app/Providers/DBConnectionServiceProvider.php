<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use App\Services\DBConnection\DBConnection;

class DBConnectionServiceProvider extends LaravelServiceProvider {

    public function register() {
        $this->app->singleton('DBConnection', function ($app) {
            return new DBConnection();
        });
    }

}
