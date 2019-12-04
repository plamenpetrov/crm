<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
//use \Auth;

class RepositoryServiceProvider extends LaravelServiceProvider {

    public function register() {

//        $this->app->bind('current.user', function() {
//            return Auth::user();
//        });
        
        $this->app->bind('App\Models\Login\Repositories\User\UserLoginRepositoryInterface', 'App\Models\Login\Repositories\User\UserLoginRepository');
        $this->app->bind('App\Models\Api\Repositories\Users\UsersRepositoryInterface', 'App\Models\Api\Repositories\Users\UsersRepository');
        
        $this->app->bind('App\Models\Api\Repositories\Navigation\NavigationRepositoryInterface', 'App\Models\Api\Repositories\Navigation\NavigationRepository');
        $this->app->bind('App\Models\Api\Repositories\Language\LanguageRepositoryInterface', 'App\Models\Api\Repositories\Language\LanguageRepository');
        $this->app->bind('App\Models\Api\Repositories\Activities\ActivitiesRepositoryInterface', 'App\Models\Api\Repositories\Activities\ActivitiesRepository');
        
        /**
         * Module Contragents
         */
        $this->app->bind('App\Models\Api\Repositories\Contragents\ContragentsRepositoryInterface', 'App\Models\Api\Repositories\Contragents\ContragentsRepository');
        $this->app->bind('App\Models\Api\Repositories\Countries\CountriesRepositoryInterface', 'App\Models\Api\Repositories\Countries\CountriesRepository');
        $this->app->bind('App\Models\Api\Repositories\Settlements\SettlementsRepositoryInterface', 'App\Models\Api\Repositories\Settlements\SettlementsRepository');
        
        $this->app->bind('App\Models\Api\Repositories\Persons\PersonsRepositoryInterface', 'App\Models\Api\Repositories\Persons\PersonsRepository');
        
        $this->app->bind('App\Models\Api\Repositories\OrganizationType\OrganizationTypeRepositoryInterface', 'App\Models\Api\Repositories\OrganizationType\OrganizationTypeRepository');
        $this->app->bind('App\Models\Api\Repositories\ContragentType\ContragentTypeRepositoryInterface', 'App\Models\Api\Repositories\ContragentType\ContragentTypeRepository');
    
        /**
         * Events 
         */
        $this->app->bind('App\Models\Api\Repositories\Events\EventsRepositoryInterface', 'App\Models\Api\Repositories\Events\EventsRepository');
        $this->app->bind('App\Models\Api\Repositories\Events\Types\EventTypeRepositoryInterface', 'App\Models\Api\Repositories\Events\Types\EventTypeRepository');
        $this->app->bind('App\Models\Api\Repositories\Events\SubTypes\EventSubTypeRepositoryInterface', 'App\Models\Api\Repositories\Events\SubTypes\EventSubTypeRepository');
    
    }

}
