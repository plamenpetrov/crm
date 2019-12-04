<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
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
