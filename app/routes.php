<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/* TEST */
Route::get('/',function(){
	return View::make('hello');
});

Route::get('inscription',function(){
	return View::make('inscription.index');
});
	Route::get('inscription/description-du-bien',function(){
	return View::make('inscription.etape1');
});
Route::post('inscription',array('before'=>'guess','uses'=>'InscriptionController@informationsPersos'));
