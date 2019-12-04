<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class ControlAccess {

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
    public function handle($request, Closure $next, $permissionAccess = '') {
        $permissions = explode(',', $permissionAccess);
        $user = $this->auth->user();

        \Acl::loadAcl();

        foreach ($permissions as $permission) {
            if (!$user->can($permission)) {
                return \Response::json(
                                [
                                    'data' => '',
                                    'message' => 'No access!!!',
                                    'status_code' => 403
                ]);
            }
        }
        
//        var_dump(1);
//        echo '=<br>';
//        die;
//        if ($this->auth->guest()) {
//            return redirect()->back();
//        }
//
//        $permissions = explode(',', $permissions);
//        $user = $this->auth->user();
//
//        \Acl::loadAcl();
//
//        foreach ($permissions as $permission) {
//            if (!$user->can($permission)) {
//                return \Response::json(
//                                [
//                                    'data' => '',
//                                    'message' => 'No access!!!',
//                                    'status_code' => 403
//                ]);
//            }
//        }

        return $next($request);
    }

}
