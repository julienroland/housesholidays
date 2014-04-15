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

/* ORDER LANGAGE FR,EN,NL,DE,ES */


/*****************************************/
/*                lang                   */
/*****************************************/


$lang = Request::segment(1);

if (in_array($lang, Config::get('app.available_locales')))
{
	App::setLocale($lang);

	

}else{

	$lang = null;

	if(!Session::has('langId')){

		

	}
}

/**
*
* 404
*
**/
/*App::missing(function($exception){

	return Response::view('missing.default',array(),404);

});*/

/**
*
* Form ajax
* @form modele
* @to relation (pays)
* @id id
*
**/
Route::get('getDataSelect/{from}/{to}/{id}',array('uses'=>'FormController@getDataSelect'));

Route::get('getChildDataSelect/{form}/{to1}/{to2}/{to3}/{id}',array('uses'=>'FormController@getChildDataSelect'));

/**
*
* Upload d'image
* @ajax
*
**/

Route::any( 'ajax/uploadImage', array('as'=>'ajax_upload_image', 'uses'=>'ImageController@postImage'));

/**
*
* Get photos de la propriete
* @ajax
*
**/

Route::any( 'getPhotoPropriete/{proprieteId}', array('as'=>'ajax_photo_propriete', 'uses'=>'ProprieteController@getPhoto'));

/**
*
* Delete
* @ajax
*
**/

Route::get( 'deleteImage/{photoId}', array( 'as'=>'ajax_delete_photo_propriete', 'uses'=>'ImageController@deletePhoto' ));

/**
*
* Ajout de tarif
* @ajax
*
**/
///{proprieteId}/{saison}/{debut}/{fin}/{duree_min}/{nuit}/{semaine}/{mois}/
Route::get('addTarif', array('as'=>'addTarif', 'uses'=>'InscriptionController@addTarif'));

Route::get('updateTarif', array('as'=>'updateTarif', 'uses'=>'InscriptionController@updateTarif'));

Route::get('deleteTarif/{id}', array('as'=>'deleteTarif', 'uses'=>'InscriptionController@deleteTarif'));

Route::get('ajax/getOneTarif/{id}', array('as'=>'getOneTarif', 'uses'=>'InscriptionController@getOneTarif'));

/**
*
* Ajout de disponibilité
*
**/

Route::get('addDispo', array('as'=>'addDispo', 'uses'=>'InscriptionController@addDispo'));

Route::get('updateDispo', array('as'=>'updateDispo', 'uses'=>'InscriptionController@updateDispo'));

Route::get('deleteDispo', array('as'=>'deleteDispo', 'uses'=>'InscriptionController@deleteDispo'));

/**
*
* Get une dispo (id);
* @ajax
*
**/

Route::get('ajax/getOneDispo/{id}', array('as'=>'getOneDispo', 'uses'=>'InscriptionController@getOneDispo'));
/**
*
* Recup des langues (pour js)
* @ajax
*
**/
Route::get('getAllLang',array('uses'=>'LangController@getAll'));

/*============================
=            test            =
============================*/
Route::get('toto', function(){

	$image = Image::make(file_get_contents('./uploads/justin.jpg'));
	File::exists(public_path().'/uploads/'.Auth::user()->id.'/proprietes/33/') or File::makeDirectory(public_path().'/uploads/'.Auth::user()->id.'/proprietes/33/');

	$image->resize(800, null)->crop(300,200)->greyScale()->save(public_path().'/uploads/'.Auth::user()->id.'/proprietes/33/justin.jpg');
	return Response::make($image, 200, array('Content-Type' => 'image/jpeg'));

});



/*-----  End of test  ------*/


/**
*
* Activation compte via mail
*
**/
Route::get('activation/{key}', array('uses'=>'InscriptionController@activation'));

/*========================================================
=            EN FONCTION DU PREFIX DANS L URL            =
========================================================*/

Route::group(array('prefix' => $lang), function() use($lang) {

	if(Helpers::isOk(Session::has('lang'))){

		App::setLocale(Session::get('lang'));

	}else{

		Session::put('lang', App::getLocale());

		App::setLocale(Session::get('lang'));
	}

	/*================================================
	=            EN FONCTION DE LA LANGUE            =
	================================================*/	
	Route::group(array('before' => 'lang'), function(){

		Route::get('test',function(  ){

		});


		Route::get('/', array('uses'=>'HomeController@index'));

		/**
		*
		* Quand on est connecté...
		*
		**/
		Route::group(array('before'=>'auth'),function(){

		/*===================================
		=            DECONNEXION            =
		===================================*/
		
		
		Route::get(Lang::get('routes.deconnexion'), array('uses'=>'ConnexionController@deconnecter'));


		/*-----  End of DECONNEXION  ------*/
		
		
		/*==============================
		=            PROFIL            =
		==============================*/

		Route::get(Lang::get('routes.compte').'/{user_slug}', array('as'=>'compte','uses'=>'CompteController@index'));

		Route::get(Lang::get('routes.compte'), function(){

			return Redirect::to( Lang::get('routes.compte').'/'. Auth::user()->slug );
		});

		/**
		*
		* Inscription du batiment
		*
		**/
		Route::get(Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape1'), array('as'=>'etape1Index','uses'=>'InscriptionController@indexBatiment'));
		
		Route::post(Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape1'), array('as'=>'inscription_etape1','uses'=>'InscriptionController@saveBatiment'));

		Route::put( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape1').'/{id}', array('as'=>'inscription_etape1_update', 'uses'=>'InscriptionController@updateBatiment'));

		/**
		*
		* Test si on a la session de la propriete crée 
		*
		**/
		
		Route::group(array('before'=>'inscription_propriete'), function(){

		/**
		*
		* Localisation du batiment
		*
		**/

		Route::get( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape2'), array('as'=>'etape2Index', 'uses'=>'InscriptionController@indexLocalisation'));

		Route::post( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape2'), array('as'=>'inscription_etape2', 'uses'=>'InscriptionController@saveLocalisation'));

		Route::put( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape2'), array('as'=>'inscription_etape2_update', 'uses'=>'InscriptionController@updateLocalisation'));

		/**
		*
		* Photos
		*
		**/
		
		Route::get( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape3'), array('as'=>'etape3Index', 'uses'=>'InscriptionController@indexPhoto'));

		Route::post( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape3'), array('uses'=>'UploadController@postImage'));

		Route::post( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape3'), array('as'=>'inscription_etape3', 'uses'=>'InscriptionController@savePhoto'));

		/**
		*
		* Tarif
		*
		**/
		
		Route::get( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape4'), array('as'=>'etape4Index', 'uses'=>'InscriptionController@indexTarif'));

		Route::post( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape4'), array('as'=>'inscription_etape4', 'uses'=>'InscriptionController@saveTarif'));

		/**
		*
		* Disponibilités
		*
		**/

		Route::get( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape5'), array('as'=>'etape5Index', 'uses'=>'InscriptionController@indexDisponibilite'));

		/**
		*
		* Paiement
		*
		**/
		
		Route::get( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_etape6'), array('as'=>'etape6Index', 'uses'=>'InscriptionController@indexPaiement'));
		
	});//filtre sur l'inscription (check si Session::get('proprieteId') est toujours présente

		/**
		*
		* Inscriptions incomplètes
		*
		**/

		Route::get( Lang::get('routes.compte').'/{user_slug}/'.Lang::get('routes.i_listLocations'), array('as'=>'listLocationPropri', 'uses'=>'CompteController@listLocation'));


		/*-----  End of PROFIL  ------*/



	});//end connecté

		/*==================================================
		=            Quand on est déconnecté...            =
		==================================================*/		
		
		Route::group(array('before'=>'guest'),function(){


		/*=================================
		=            CONNEXION            =
		=================================*/


		/**
		*
		* Se connecter
		*
		**/
		Route::get(Lang::get('routes.connexion'),array('uses'=>'ConnexionController@index'));

		Route::post(Lang::get('routes.connexion'),array('as'=>'connexion','uses'=>'ConnexionController@connectUser'));

		/*-----  End of CONNEXION  ------*/


		/*===================================
		=            INSCRIPTION            =
		===================================*/


		/**
		*
		* Inscription du user
		*
		**/
		Route::get(Lang::get('routes.inscription'),array('uses'=>'InscriptionController@index'));

		Route::post(Lang::get('routes.inscription'),array('as'=>'inscription','uses'=>'InscriptionController@saveUser'));

		
		

		/*-----  End of INSCRIPTION  ------*/

	});
		/*-----  End of Quand on est déconnecté...  ------*/

		/**
		*
		* Lier le modele Pays au parametre {slug} 
		*
		**/

		Route::bind('pays_slug', function($value, $route)
		{	

			return Pays::where('initial_2', $value)->firstOrFail();

		});

		/**
		*
		* Lier le modele Region au parametre {slug} 
		*
		**/

		Route::bind('region_slug', function($value, $route)
		{	

			return RegionTraduction::where(Config::get('var.lang_col'), Session::get('langId'))->where('slug', $value)->firstOrFail();

		});

		/**
		*
		* List des régions par pays de la carte sur la page d'accueil
		*
		**/

		Route::get( Lang::get('general.locationsVacances').'/{pays_slug}/{region_slug}', array('as'=>'getLocationsFormPaysAndRegion','uses'=>'HomeController@getList'));
		
		/**
		*
		* Lier le modele Propriete au parametre {slug} 
		*
		**/
		Route::bind('propriete_slug', function($value, $route)
		{	

			return Propriete::whereSlug($value)->firstOrFail();

		});
		/**
		*
		* Location
		*
		**/

		/*==========  Voir  ==========*/

		Route::get('{propriete_slug}', array('as'=>'showPropriete', 'uses'=>'ProprieteController@show'));

		/*==========  Edit  ==========*/

		Route::get(strtolower(Lang::get('form.modifier')).'/{propriete_slug}/'.Lang::get('routes.i_etape1'), array('as'=>'editPropriete', 'uses'=>'InscriptionController@indexBatiment'));

	});
/*-----  End of EN FONCTION DE LA LANGUE  ------*/

});
/*-----  End of EN FONCTION DU PREFIX DANS L URL  ------*/
