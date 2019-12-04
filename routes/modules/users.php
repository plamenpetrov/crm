<?php

Route::group(['prefix' => 'users'], function () {
    Route::get('/', ['as' => 'users', 'uses' => 'UserController@index'])
            ->middleware('acl:users');

    Route::get('/create', ['as' => 'user_create', 'uses' => 'UserController@create'])
            ->middleware('acl:users-create');

    Route::get('/{id}/edit', ['as' => 'user_edit', 'uses' => 'UserController@edit'])
            ->middleware('acl:users-edit');

    Route::get('/show/{id}', ['as' => 'user_show', 'uses' => 'UserController@show'])
            ->middleware('acl:users-show');

    Route::post('/store', ['as' => 'user_store', 'uses' => 'UserController@store'])
            ->middleware('acl:users-store');

    Route::patch('/update/{id}', ['as' => 'user_update', 'uses' => 'UserController@update'])
            ->middleware('acl:users-update');
    
    Route::get('/search/{user}', ['as' => 'user_search', 'uses' => 'UserController@search'])
            ->middleware('acl:users-search');
});
