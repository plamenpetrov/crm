<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthJWT
{
    protected $response;
    public function __construct()
    {
        //
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next) {

        //ne se izpolzva ...
        $token = \JWTAuth::getToken();

        if (! $token) {
            throw new \BadRequestHttpException('Token not provided');
        }

        try {
            $token = \JWTAuth::refresh($token);
        } catch (TokenInvalidException $e) {
            throw new AccessDeniedHttpException('The token is invalid');
        }
        
        return response()->json(compact('token'));

        var_dump($token);
        echo '=<br>';
        die;

        return $this->setAuthenticationHeader($response, $newtoken); // Response with new token on header Authorization.
    }
}