<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Application;

//use \SystemLanguage;
//use Illuminate\Support\Facades\Auth;

class BeforeMiddleware {

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
    public function __construct(Guard $auth, Application $app) {
        $this->auth = $auth;
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
//        \LangDir::setLanguageNamespace();
//        \DBConnection::setDBconnection();
//        \App::setLocale(\Session::get('lang', 'bg'));
//        if ($this->auth->guest()) {
//            return redirect()->back();
//        }

        $payload = auth()->payload();
        
        $clientKey = $payload['clientKey'];
        // read the language from the request header
        $locale = $request->header('Content-Language');

        // if the header is missed
        if (!$locale) {
            // take the default local language
            $locale = $this->app->config->get('clients.' . $clientKey . '.language');
        }

        // check the languages defined is supported
//        if (!array_key_exists($locale, $this->app->config->get('app.supported_languages'))) {
//            // respond with error
//            return abort(403, 'Language not supported.');
//        }
        // set the local language
        $this->app->setLocale($locale);

//        $user = \JWTAuth::toUser($request->token);

        \DBConnection::setDBconnection($clientKey);
        \SystemLanguage::setLanguage($locale);
//        \Session::put('langId', );
        \LangDir::setLanguageNamespace($clientKey);

        // get the response after the request is done
        $response = $next($request);

        // set Content Languages header in the response
        $response->headers->set('Content-Language', $locale);

        return $response;
    }

}
