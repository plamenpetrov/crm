<?php

//\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//    var_dump($query->sql);
//    var_dump($query->bindings);
//    var_dump($query->time);
//});
Route::group(['prefix' => 'contragents'], function () {
    Route::get('/', ['as' => 'contragents', 'uses' => 'ContragentController@index'])
            ->middleware('acl:contragents');
    Route::get('/create', ['as' => 'contragent_create', 'uses' => 'ContragentController@create'])
            ->middleware('acl:contragents-create');
    Route::get('/{id}/edit', ['as' => 'contragent_edit', 'uses' => 'ContragentController@edit'])
            ->middleware('acl:contragents-edit');
    Route::get('/show/{id}', ['as' => 'contragent_show', 'uses' => 'ContragentController@show'])
            ->middleware('acl:contragents-show');
    Route::get('/history/{id}', ['as' => 'contragents_history', 'uses' => 'ContragentController@history'])
            ->middleware('acl:contragents-history');
    Route::post('/store', ['as' => 'contragent_store', 'uses' => 'ContragentController@store'])
            ->middleware('acl:contragents-store');
    Route::patch('/update/{id}', ['as' => 'contragent_update', 'uses' => 'ContragentController@update'])
            ->middleware('acl:contragents-update');
    Route::get('/search/{contragent}', ['as' => 'contragent_search', 'uses' => 'ContragentController@search'])
            ->middleware('acl:contragents-search');
    
    /**RELATIONS**/
    Route::post('/relation/store', ['as' => 'contragent_relation', 'uses' => 'ContragentController@storeRelation'])
            ->middleware('acl:contragents-store-relation');
    
    Route::delete('/relation/delete', ['as' => 'contragent_relation_delete', 'uses' => 'ContragentController@deleteRelation'])
            ->middleware('acl:contragents-delete-relation');
    
    Route::post('/person/store', ['as' => 'contragent_person', 'uses' => 'ContragentController@storePerson'])
            ->middleware('acl:contragents-store-person');
    
    Route::delete('/person/delete', ['as' => 'contragent_person_delete', 'uses' => 'ContragentController@deletePerson'])
            ->middleware('acl:contragents-delete-person');
});
