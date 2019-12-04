<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use App\Services\LangDir\LangDir as LangDir;

class LangDirServiceProvider extends LaravelServiceProvider {

    public function register() {
        $this->app->singleton('LangDir', function ($app) {
            return new LangDir();
        });
    }

}
