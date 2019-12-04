<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Input as Input;

class AfterMiddleware {

    public function handle($request, Closure $next) {
        $response = $next($request);

        //TO DO: Sometimes $response->getData(true) is not defined
        // Perform action
//        if ($request->method() === 'GET' && !Auth::guest()) {
//            $route = Session::get('currentRoute');
//            $route = \Route::currentRouteAction();
////            var_dump(\Session::all());echo '=<br>';die;
//            $responseData = $response->getData(true);
//            $responseData['UI']['allowed_routes'] = \UI::getRouteElements($route);
//            $responseData['UI']['translations'] = \UI::getTranslationsByRoute($route);
//            $responseData['UI']['avatar'] = \Auth::user()->profile_picture;
//            if (Input::has('client_route'))
//                $responseData['UI']['currentWidgets'] = \UI::getcurrentWidgets(Input::get('client_route'));
//            $responseData['openedObjectsCount'] = \DB::table('sys_cache_tables_registry')->where('id_user', '=', \Auth::user()->id)->count();
//            $response->setData($responseData);
//        }

        /**
         * Log tracable routes
         */
        if (Session::has('trackable_routes.' . Session::get('currentRoute')) && Input::get('client_route')) {
            \RouteTracking::firstOrCreate([
                'id_user' => Session::get('user_id'),
                'route' => Session::get('currentRoute'),
                'client_route' => Input::get('client_route'),
                'device' => Session::get('device', NULL),
                'method' => $request->method(),
                'opened_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'status_code' => $response->getData(true)['status_code']
            ]);
        }

        return $response;
    }

}
