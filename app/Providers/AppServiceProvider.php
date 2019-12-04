<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
//        \DB::listen(function ($query) {
//            \Log::info($query->sql);
//            
////            var_dump([
////                $query->sql,
////                $query->bindings,
////                $query->time
////            ]);
//        });
        Carbon::serializeUsing(function ($carbon) {
            return $carbon->format('Y-m-d H:m:s');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
