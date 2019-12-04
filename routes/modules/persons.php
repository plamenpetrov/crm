<?php

//\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//    var_dump($query->sql);
//    var_dump($query->bindings);
//    var_dump($query->time);
//});

Route::group(['prefix' => 'persons'], function () {
    Route::get('/', ['as' => 'persons', 'uses' => 'PersonController@index'])
            ->middleware('acl:persons');
    Route::get('/create', ['as' => 'person_create', 'uses' => 'PersonController@create'])
            ->middleware('acl:persons-create');
    Route::get('/{id}/edit', ['as' => 'person_edit', 'uses' => 'PersonController@edit'])
            ->middleware('acl:persons-edit');
    Route::get('/show/{id}', ['as' => 'person_show', 'uses' => 'PersonController@show'])
            ->middleware('acl:persons-show');
    Route::post('/store', ['as' => 'person_store', 'uses' => 'PersonController@store'])
            ->middleware('acl:persons-store');
    Route::patch('/update/{id}', ['as' => 'person_update', 'uses' => 'PersonController@update'])
            ->middleware('acl:persons-update');
    
    Route::get('/search/{person}', ['as' => 'person_search', 'uses' => 'PersonController@search'])
            ->middleware('acl:persons-search');
    
    Route::get('/history/{id}', ['as' => 'persons_history', 'uses' => 'PersonController@history'])
            ->middleware('acl:persons-history');
});
