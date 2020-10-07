<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'API'], function () {
    Route::resource('/condominio', 'CondominioController', ['except' => 'edit']);
    Route::resource('/bloco', 'BlocoController', ['except' => 'edit']);
    // Route::post('/condominio', 'CondominioController@store');
    // Route::get('/condominio/{id}', 'CondominioController@show');
    // Route::put('/condominio/{id}', 'CondominioController@update');
    // Route::delete('/condominio/{id}', 'CondominioController@destroy');
});
