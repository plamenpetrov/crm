<?php

//use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

//Route::group(['middleware' => ['auth:api'], 'prefix' => 'api/v1/auth'], function () {
//    Route::post('/login', function (Request $request) {
//        return response()->json(['name' => 'test']);
//    });
//});

Route::group(['middleware' => ['auth:api'], 'prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'AuthController@login');
        Route::post('/logout', 'AuthController@logout');
        Route::post('/refresh', 'AuthController@refresh');
    });

    Route::group(['middleware' => ['jwt.auth', 'jwt.refresh', 'before']], function () {
        foreach (glob(__DIR__ . '/modules/*.php') as $route_file) {
            require $route_file;
        }
//        Route::group(['middleware' => ['before']], function () {
        Route::get('/navigation/{type?}', ['as' => 'get_navigations', 'uses' => 'UIController@getNavigations'])
                ->middleware('acl:navigation');

        Route::get('/language/{lang}', ['as' => 'change_lang', 'uses' => 'UIController@setLang'])
                ->middleware('acl:language-change');

        Route::get('/activity', ['as' => 'get_activity', 'uses' => 'UIController@getActivity'])
                ->middleware('acl:activity');

//        });
    });
});
//
//Route::group(['prefix' => 'api/v1'], function () {
//    Route::get('/login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
//    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
//
//    Route::post('/login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
//
//    Route::group(['middleware' => ['auth']], function () {
//        Route::get('/navigation/{type?}', ['as' => 'get_navigations', 'uses' => 'UIController@getNavigations'])
//                ->middleware('acl:navigation');
//
//        Route::get('/language/{lang}', ['as' => 'change_lang', 'uses' => 'UIController@setLang'])
//                ->middleware('acl:language-change');
//
//        Route::get('/activity', ['as' => 'get_activity', 'uses' => 'UIController@getActivity'])
//                ->middleware('acl:activity');
//        
//        foreach (glob(__DIR__ . '/modules/*.php') as $route_file) {
//            require $route_file;
//        }
//    });
//});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
