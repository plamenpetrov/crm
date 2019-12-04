<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use App\Services\Response\ResponseApi;

class ResponseApiServiceProvider extends LaravelServiceProvider {

    public function register() {
        $this->app->singleton('ResponseApi', function ($app) {
            return new ResponseApi();
        });
    }

}
