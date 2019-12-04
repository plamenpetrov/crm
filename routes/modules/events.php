<?php

Route::group(['prefix' => 'events'], function () {
    Route::get('/', ['as' => 'events', 'uses' => 'EventController@index'])
            ->middleware('acl:events');

    Route::get('/create', ['as' => 'event_create', 'uses' => 'EventController@create'])
            ->middleware('acl:events-create');

    Route::get('/{id}/edit', ['as' => 'event_edit', 'uses' => 'EventController@edit'])
            ->middleware('acl:events-edit');

    Route::get('/show/{id}', ['as' => 'event_show', 'uses' => 'EventController@show'])
            ->middleware('acl:events-show');

    Route::post('/store', ['as' => 'event_store', 'uses' => 'EventController@store'])
            ->middleware('acl:events-store');

    Route::patch('/update/{id}', ['as' => 'event_update', 'uses' => 'EventController@update'])
            ->middleware('acl:events-update');
    
    Route::patch('/change/duration/{id}', ['as' => 'event_change_duration', 'uses' => 'EventController@changeDuration'])
            ->middleware('acl:events-change-duration');

    Route::get('/search/{event}', ['as' => 'event_search', 'uses' => 'EventController@search'])
            ->middleware('acl:events-search');
});
