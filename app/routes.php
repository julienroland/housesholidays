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
/* ORDER LANGAGE FR,EN,NL,DE,ES
/*****************************************/
/*                lang                   */
/*****************************************/


$lang = Request::segment(1);

if (in_array($lang, Config::get('app.available_locales')))
{
	App::setLocale($lang);

}else{

	$lang = null;
}

/**
*
* 404
*
**/
App::missing(function($exception){

    return Response::view('missing.default',array(),404);

});
/**
*
* Activation compte via mail
*
**/
Route::get('activation/{key}', array('uses'=>'InscriptionController@activation'));

Route::group(array('prefix' => $lang), function() use($lang) {

	/*App::setLocale(Session::get('lang'));*/

	Route::group(array('before' => 'lang'), function(){

		Route::get('test',function(  ){

		});
	/**
	*
	* Test si la session est vide, si oui je sais qu'il n'y a pas de prefix dans l'url. Je cherche donc la langue locale et je la charge.
	*
	**/
	
	/*helpers::ifNotSessionLangId();*/

	/*Route::group(array('before'=>'guess'),function(){*/

		/* INSCRIPTION*/
		Route::get('/',function(){
			dd('home');

			/*return Redirect::route('inscription');*/
			/*dd(Session::get('langId'));*/

		});

		/**
		*
		* Informations du user
		*
		**/
		Route::get(Lang::get('routes.inscription'),array('uses'=>'InscriptionController@index'));

		Route::post(Lang::get('routes.inscription'),array('as'=>'inscription','uses'=>'InscriptionController@saveUser'));


		Route::get(Lang::get('routes.inscription').'/'.Lang::get('routes.i_etape1'),array('as'=>'inscription_etape1','uses'=>'InscriptionController@saveBatiment'));
		
		Route::post('inscription/informations-personnelles',array('uses'=>'InscriptionController@informationsPersos'));
		/* END ETAPE1 */

		/* ETAPE2 */
		Route::get('inscription/description-du-bien',array('as'=>'inscription_etape2',function(){
			return View::make('inscription.etape2');
		}));
		Route::post('inscription/description-du-bien',array('uses'=>'InscriptionController@informationsPersos'));
		/* END ETAPE2 */


		/* END INSCRIPTION*/
		/*});*/

});
});

