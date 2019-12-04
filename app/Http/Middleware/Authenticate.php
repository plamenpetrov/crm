<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use \Auth;
use \Response;

class Authenticate {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {

//        if (Auth::guard($guard)->guest()) {
//            if ($request->ajax() || $request->wantsJson()) {
////                return response('Unauthorized.', 401);
//                return Response::json(
//                                [
//                            'data' => '',
//                            'message' => 'Unauthorized',
//                            'status_code' => 401
//                                ]);
//            } else {
//                return Response::json(
//                        [
//                    'data' => '',
//                    'message' => 'Access denied. Please sign in',
//                    'status_code' => 401
//                ]);
//            }
//        }

        return $next($request);
    }

}
