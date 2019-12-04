<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use App\Services\SystemLanguage\SystemLanguage;

class LanguageServiceProvider extends LaravelServiceProvider {

    public function register() {
        $this->app->singleton('SystemLanguage', function ($app) {
            return new SystemLanguage();
        });
    }

}
