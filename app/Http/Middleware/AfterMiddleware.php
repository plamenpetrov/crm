<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Input as Input;

class AfterMiddleware {

    public function handle($request, Closure $next) {
        $response = $next($request);

        return $response;
    }

}
