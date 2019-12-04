<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use App\Services\Translation\Translate as Translate;

class TranslationServiceProvider extends LaravelServiceProvider {

    public function register() {
        $this->app->singleton('Translate', function ($app) {
            return new Translate();
        });
    }

}
