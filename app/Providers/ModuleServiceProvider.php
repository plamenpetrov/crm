<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use App\Services\Contragents\Contragents as Contragents;
use App\Services\Contragents\Persons as Persons;
use App\Services\Events\Events;
use App\Services\Users\Users;

class ModuleServiceProvider extends LaravelServiceProvider {

    public function register() {
        $this->app->singleton('contragents', function ($app) {
            return new Contragents(
                $app->make('App\Models\Api\Repositories\Contragents\ContragentsRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\Language\LanguageRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\Countries\CountriesRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\Settlements\SettlementsRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\OrganizationType\OrganizationTypeRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\ContragentType\ContragentTypeRepositoryInterface')
            );
        });
        
        $this->app->singleton('persons', function ($app) {
            return new Persons(
                $app->make('App\Models\Api\Repositories\Persons\PersonsRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\Language\LanguageRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\Settlements\SettlementsRepositoryInterface')
            );
        });
        
        $this->app->singleton('myevents', function ($app) {
            return new Events(
                $app->make('App\Models\Api\Repositories\Events\EventsRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\Events\Types\EventTypeRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\Events\SubTypes\EventSubTypeRepositoryInterface'),
                $app->make('\App\Models\Api\Repositories\Users\UsersRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\Language\LanguageRepositoryInterface')
            );
        });
        
        $this->app->singleton('myusers', function ($app) {
            return new Users(
                $app->make('\App\Models\Api\Repositories\Users\UsersRepositoryInterface'),
                $app->make('App\Models\Api\Repositories\Language\LanguageRepositoryInterface')
            );
        });
    }

}
