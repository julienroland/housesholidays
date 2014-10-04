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

    Session::put('lang', $lang);


} else
{

    $lang = null;

    /*if(!Session::has('langId')){



    }*/
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
Route::get('getDataSelect/{from}/{to}/{id}', array('uses' => 'FormController@getDataSelect'));

Route::get('getChildDataSelect/{form}/{to1}/{to2}/{to3}/{id}', array('uses' => 'FormController@getChildDataSelect'));

/**
 *
 * Recup des langues (pour js)
 * @ajax
 *
 **/
Route::get('getAllLang', array('uses' => 'LangController@getAll'));

/*============================
=            test            =
============================*/
Route::get('toto', function ()
{

    $image = Image::make(file_get_contents('./uploads/justin.jpg'));
    File::exists(public_path() . '/uploads/' . Auth::user()->id . '/proprietes/33/') or File::makeDirectory(public_path() . '/uploads/' . Auth::user()->id . '/proprietes/33/');

    $image->resize(800, null)->crop(300, 200)->greyScale()->save(public_path() . '/uploads/' . Auth::user()->id . '/proprietes/33/justin.jpg');

    return Response::make($image, 200, array('Content-Type' => 'image/jpeg'));

});


/*-----  End of test  ------*/

/**
 *
 * Lier le modele Propriete au parametre {id}
 *
 **/
Route::bind('propriete_id', function ($value, $route)
{

    return Propriete::findOrFail($value);

});

/**
 *
 * Activation compte via mail
 *
 **/
Route::get('activation/{key}', array('uses' => 'InscriptionController@activation'));

/*========================================================
=            EN FONCTION DU PREFIX DANS L URL            =
========================================================*/

Route::group(array('prefix' => $lang), function () use ($lang)
{

    if (Helpers::isOk(Session::has('lang')))
    {

        App::setLocale(Session::get('lang'));

    } else
    {

        Session::put('lang', App::getLocale());

        App::setLocale(Session::get('lang'));
    }


    /*================================================
    =            EN FONCTION DE LA LANGUE            =
    ================================================*/
    Route::group(array('before' => 'lang'), function ()
    {

        App::setLocale(Helpers::isOk(Session::get('lang')) ? Session::get('lang') : Config::get('app.locale'));

        Route::get('test', function ()
        {

        });


        /**
         * Get home région en fonction du pays
         *
         * @param integer pays_id
         * @return
         */
        Route::get('getRegionFromPays/{pays_id}', ['uses' => 'RechercheController@regionFromPays']);
        /**
         * Get home région en fonction du pays
         *
         * @param integer region_id
         * @return
         */
        Route::get('getSousRegionFromRegion/{region_id}', ['uses' => 'RechercheController@sousRegionFromRegion']);

        Route::get('/', array('as'=>'home','uses' => 'HomeController@index'));

        Route::get(trans('routes.locations_vacances') . '/', ['as' => 'homeSearch', 'uses' => 'HomeController@homeSearch']);

        Route::get('quick-search', ['as' => 'homeQuickSearch', 'uses' => 'HomeController@quickSearch']);

        /**
         *
         * Recherche via la carte
         *
         **/

        Route::get(trans('routes.locations_vacances') . '/' . trans('routes.location') . '-{pays?}/{region?}/{sousRegion?}', array('as' => 'rechercheCarte', 'uses' => 'RechercheController@carte'));

        /**
         *
         * Carte
         *
         **/

        Route::get('france', function ()
        {

            $pays = Helpers::cache(Pays::whereId(77)->with(array('PaysTraduction'))->first(), 'france_regions'. Session::get('langId'));
            $regions = Pays::listById(77);

            return View::make('carte.france', array('page' => 'carte'))
                ->with(compact('regions', 'pays'));
        });

        /**
         *
         * Voir une location
         *
         **/

        Route::get(trans('routes.locations_vacances') . '/{slug}', array('as' => 'displayPropriete', 'uses' => 'ProprieteController@show'));

        /**
         *
         * Changer la langue
         *
         **/

        Route::get('changelangue', array('as' => 'changeLangue', 'uses' => 'LangController@change'));

        /**
         *
         * Quand on est connecté...
         *
         **/
        Route::group(array('before' => 'auth'), function ()
        {

            /**
             *
             * Send de messages
             * @ajax
             *
             **/

            Route::get('envoyeMessage', array('as' => 'sendMessage', 'uses' => 'UserController@sendMessage'));

            Route::get('repondreMessage', array('as' => 'repondreMessage', 'uses' => 'UserController@repondreMessage'));

            /**
             *
             * Add favoris
             * @ajax
             *
             **/

            Route::get('addFavoris/{userId}/{proprieteId}', array('as' => 'addFavoris', 'uses' => 'UserController@addFavoris'));

            /**
             *
             * Delete favoris
             * @ajax
             *
             **/

            Route::get('deleteFavoris/{userId}/{proprieteId}', array('as' => 'deleteFavoris', 'uses' => 'UserController@deleteFavoris'));
            /**
             *
             * Upload d'image
             * @ajax
             *
             **/

            Route::any('ajax/uploadImage/{id}', array('as' => 'ajax_upload_image', 'uses' => 'ImageController@postImage'));

            /**
             *
             * Get photos de la propriete
             * @ajax
             *
             **/

            Route::any('getPhotoPropriete/{proprieteId}', array('as' => 'ajax_photo_propriete', 'uses' => 'ProprieteController@getPhoto'));

            /**
             *
             * Delete
             * @ajax
             *
             **/

            Route::get('deleteImage/{photoId}/{proprieteId}', array('as' => 'ajax_delete_photo_propriete', 'uses' => 'ImageController@deletePhoto'));


            /**
             *
             * Ajout de tarif
             * @ajax
             *
             **/
///{proprieteId}/{saison}/{debut}/{fin}/{duree_min}/{nuit}/{semaine}/{mois}/
            Route::get('addTarif', array('as' => 'addTarif', 'uses' => 'InscriptionController@addTarif'));

            Route::get('updateTarif', array('as' => 'updateTarif', 'uses' => 'InscriptionController@updateTarif'));

            Route::get('deleteTarif/{id}', array('as' => 'deleteTarif', 'uses' => 'InscriptionController@deleteTarif'));

            Route::get('ajax/getOneTarif/{id}', array('as' => 'getOneTarif', 'uses' => 'InscriptionController@getOneTarif'));

            /**
             *
             * Ajout de disponibilité
             *
             **/

            Route::get('addDispo', array('as' => 'addDispo', 'uses' => 'InscriptionController@addDispo'));

            Route::get('updateDispo', array('as' => 'updateDispo', 'uses' => 'InscriptionController@updateDispo'));

            Route::get('deleteDispo', array('as' => 'deleteDispo', 'uses' => 'InscriptionController@deleteDispo'));

            /**
             *
             * Get une dispo (id);
             * @ajax
             *
             **/

            Route::get('ajax/getOneDispo/{id}', array('as' => 'getOneDispo', 'uses' => 'InscriptionController@getOneDispo'));
            /**
             *
             * Envoye de commentaires sur annonce
             *
             **/

            Route::post(trans('routes.send_commentaire'), array('as' => 'sendCommentaire', 'uses' => 'UserController@sendCommentaire'));

            /**
             *
             * Doit se faire après un filtre qui test si annonce payée !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             *
             **/


            Route::get('refreshAnnonce/{propriete_id}', array('as' => 'RefreshAnnonce', 'uses' => 'ProprieteController@refresh'));

            /**
             *
             * END Filtre Annonce payé
             *
             **/


            /*===================================
            =            DECONNEXION            =
            ===================================*/


            Route::get(Lang::get('routes.deconnexion'), array('as' => 'deconnexion', 'uses' => 'ConnexionController@deconnecter'));


            /*-----  End of DECONNEXION  ------*/


            /*-----  End of ADMIN  ------*/


            /*==============================
            =            PROFIL            =
            ==============================*/

            Route::get(Lang::get('routes.compte') . '/{user_slug}', array('as' => 'compte', 'uses' => 'CompteController@index'));

            Route::get(Lang::get('routes.compte'), function ()
            {

                return Redirect::to(Lang::get('routes.compte') . '/' . Auth::user()->slug);
            });

            /**
             *
             * Suppression des anciennes sessions d'ancienne création de propriete
             *
             **/
            Route::bind('propriete_id', function ($value, $route)
            {

                $isOwner = Auth::user()->propriete()->whereId($value)->first();

                if (Helpers::isNotOk($isOwner) && Auth::user()->role_id < Config::get('var.admin_role'))
                {

                    throw new NotFoundHttpException;
                }

                /*if(Helpers::isNotOk($isOwner)){
                    $isOwner = Propriete::findOrFail($value);
                }
    */

                return $isOwner;
            });

            Route::get(Lang::get('routes.compte') . '/{user_slug}/checkSession', array('as' => 'checkSession', 'uses' => 'InscriptionController@checkSession'));

            /**
             *
             * Inscription du batiment
             *
             **/
            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape1') . '/{propriete_id?}', array('as' => 'etape1Index', 'uses' => 'InscriptionController@indexBatiment'));

            Route::post(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape1') . '/{propriete_id?}', array('as' => 'inscription_etape1', 'uses' => 'InscriptionController@saveBatiment'));

            Route::put(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape1') . '/{propriete_id}', array('as' => 'inscription_etape1_update', 'uses' => 'InscriptionController@updateBatiment'));


            /**
             *
             * Localisation du batiment
             *
             **/

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape2') . '/{propriete_id}', array('as' => 'etape2Index', 'uses' => 'InscriptionController@indexLocalisation'));

            Route::post(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape2') . '/{propriete_id}', array('as' => 'inscription_etape2', 'uses' => 'InscriptionController@saveLocalisation'));

            Route::put(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape2') . '/{propriete_id}', array('as' => 'inscription_etape2_update', 'uses' => 'InscriptionController@updateLocalisation'));

            /**
             *
             * Photos
             *
             **/

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape3') . '/{propriete_id}', array('as' => 'etape3Index', 'uses' => 'InscriptionController@indexPhoto'));

            Route::post(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape3') . '/{propriete_id}', array('uses' => 'UploadController@postImage'));

            Route::post(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape3') . '/{propriete_id}', array('as' => 'inscription_etape3', 'uses' => 'InscriptionController@savePhoto'));

            Route::put(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape3') . '/{propriete_id}', array('as' => 'inscription_etape3_update', 'uses' => 'InscriptionController@updatePhoto'));

            /**
             *
             * Tarif
             *
             **/

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape4') . '/{propriete_id}', array('as' => 'etape4Index', 'uses' => 'InscriptionController@indexTarif'));

            Route::post(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape4') . '/{propriete_id}', array('as' => 'inscription_etape4', 'uses' => 'InscriptionController@saveTarif'));

            Route::put(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape4') . '/{propriete_id}', array('as' => 'inscription_etape4_update', 'uses' => 'InscriptionController@updateTarif2'));

            /**
             *
             * Disponibilités
             *
             **/

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape5') . '/{propriete_id}', array('as' => 'etape5Index', 'uses' => 'InscriptionController@indexDisponibilite'));

            /**
             *
             * Coordonnés
             *
             **/

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape6') . '/{propriete_id}', array('as' => 'etape6Index', 'uses' => 'InscriptionController@indexCoordonne'));

            Route::post(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape6') . '/{propriete_id}', array('as' => 'inscription_etape6', 'uses' => 'InscriptionController@saveCoordonne'));

            Route::put(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape6') . '/{propriete_id}', array('as' => 'inscription_etape6_update', 'uses' => 'InscriptionController@updateCoordonne'));

            /**
             *
             * Paiement
             *
             **/

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_etape7') . '/{propriete_id}', array('as' => 'etape7Index', 'uses' => 'InscriptionController@indexPaiement'));


            /**
             *
             * Inscriptions incomplètes
             *
             **/

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . Lang::get('routes.i_listLocations'), array('as' => 'listLocationPropri', 'uses' => 'CompteController@listLocation'));

            /**
             *
             * Commentaires de l'utilisateurs
             *
             **/

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . trans('routes.listCommentaires'), array('as' => 'listCommentaires', 'uses' => 'UserController@listCommentaires'));

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . trans('routes.desactive_commentaires') . '/{id}', array('as' => 'desactiverCommentaire', 'uses' => 'UserController@desactiverCommentaire'));

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . trans('routes.active_commentaires') . '/{id}', array('as' => 'activerCommentaire', 'uses' => 'UserController@activerCommentaire'));

            /**
             *
             * Messages
             *
             **/

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . trans('routes.listMessages'), array('as' => 'listMessages', 'uses' => 'UserController@listMessage'));

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . trans('routes.repondreMessage') . '/{id}', array('as' => 'repondre_message', 'uses' => 'UserController@repondreMessage'));

            /**
             *
             * Favoris
             *
             **/

            Route::get(Lang::get('routes.compte') . '/{user_slug}/' . trans('routes.listFavoris'), array('as' => 'listFavoris', 'uses' => 'UserController@listFavoris'));

            /*-----  End of PROFIL  ------*/

            /**
             *
             * Location
             *
             **/


            /*==========  Voir  ==========*/

            Route::get(Lang::get('routes.voir') . '/{propriete_id}', array('as' => 'showPropriete', 'uses' => 'ProprieteController@show'));

            /*==========  Delete  ==========*/

            Route::get(Lang::get('routes.delete') . '/{propriete_id}', array('as' => 'deletePropriete', 'uses' => 'ProprieteController@delete'));

            /*==========  Edit  ==========*/


            /**
             *
             * Inscription du bien
             *
             **/

            Route::get(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape1'), array('as' => 'editPropriete1', 'uses' => 'InscriptionController@indexBatiment'));

            Route::put(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape1'), array('as' => 'storePropriete1', 'uses' => 'InscriptionController@updateBatiment'));

            /**
             *
             * Localisation
             *
             **/

            Route::get(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape2'), array('as' => 'editPropriete2', 'uses' => 'InscriptionController@indexLocalisation'));

            Route::put(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape2'), array('as' => 'storePropriete2', 'uses' => 'InscriptionController@updateLocalisation'));

            /**
             *
             * Photos videos
             *
             **/

            Route::get(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape3'), array('as' => 'editPropriete3', 'uses' => 'InscriptionController@indexPhoto'));

            Route::put(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape3'), array('as' => 'storePropriete3', 'uses' => 'InscriptionController@updatePhoto'));

            /**
             *
             * Tarifs
             *
             **/

            Route::get(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape4'), array('as' => 'editPropriete4', 'uses' => 'InscriptionController@indexTarif'));

            Route::put(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape4'), array('as' => 'storePropriete4', 'uses' => 'InscriptionController@updateTarif2'));

            /**
             *
             * Dispo
             *
             **/

            Route::get(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape5'), array('as' => 'editPropriete5', 'uses' => 'InscriptionController@indexDisponibilite'));

            Route::put(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape5'), array('as' => 'storePropriete5', 'uses' => 'InscriptionController@updateDispo'));

            /**
             *
             * Coordonnées
             *
             **/

            Route::get(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape6'), array('as' => 'editPropriete6', 'uses' => 'InscriptionController@indexCoordonne'));

            Route::put(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape6'), array('as' => 'storePropriete6', 'uses' => 'InscriptionController@updateCoordonne'));

            /**
             *
             * Paiement
             *
             **/

            Route::get(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape7'), array('as' => 'editPropriete7', 'uses' => 'InscriptionController@indexLocalisation'));

            Route::put(strtolower(Lang::get('form.modifier')) . '/{propriete_id}/' . Lang::get('routes.i_etape7'), array('as' => 'storePropriete7', 'uses' => 'InscriptionController@updateLocalisation'));

        });//end connecté

        /*==================================================
        =            Quand on est déconnecté...            =
        ==================================================*/

        Route::group(array('before' => 'guest'), function ()
        {


            /*=================================
            =            CONNEXION            =
            =================================*/


            /**
             *
             * Se connecter
             *
             **/
            Route::get(Lang::get('routes.connexion'), array('uses' => 'ConnexionController@index'));

            Route::post(Lang::get('routes.connexion'), array('as' => 'connexion', 'uses' => 'ConnexionController@connectUser'));

            /*-----  End of CONNEXION  ------*/


            /*===================================
            =            INSCRIPTION            =
            ===================================*/


            /**
             *
             * Inscription du user
             *
             **/
            Route::get(Lang::get('routes.inscription'), array('uses' => 'InscriptionController@index'));

            Route::post(Lang::get('routes.inscription'), array('as' => 'inscription', 'uses' => 'InscriptionController@saveUser'));


            /*-----  End of INSCRIPTION  ------*/

        });
        /*-----  End of Quand on est déconnecté...  ------*/

        /**
         *
         * Lier le modele Pays au parametre {slug}
         *
         **/

        Route::bind('pays_slug', function ($value, $route)
        {

            return Pays::where('initial_2', $value)->firstOrFail();

        });

        /**
         *
         * Lier le modele Region au parametre {slug}
         *
         **/

        Route::bind('region_slug', function ($value, $route)
        {

            return RegionTraduction::where(Config::get('var.lang_col'), Session::get('langId'))->where('slug', $value)->firstOrFail();

        });

        /**
         *
         * List des régions par pays de la carte sur la page d'accueil
         *
         **/

        Route::get(Lang::get('general.locationsVacances') . '/{pays_slug}/{region_slug?}', array('as' => 'getLocationsFromPaysAndRegion', 'uses' => 'HomeController@getList'));


    });
    /*-----  End of EN FONCTION DE LA LANGUE  ------*/

});
/*-----  End of EN FONCTION DU PREFIX DANS L URL  ------*/

/*=============================
 =            ADMIN           =
 =============================*/


Route::group(array('prefix' => 'admin','before'=>'auth'), function ()
{


    Route::post('connecter', array('as' => 'connecter', 'uses' => 'Admin_UserController@connecter'));

    Route::group(array('before' => 'admin'), function ()
    {
        /**
         *
         * Traductions statiques
         *
         **/

        Route::controller('traductions/statiques', 'Barryvdh\TranslationManager\Controller');

        /**
         *
         * Desactiver/activer annonce
         *
         **/

        Route::get('propriete/desactiver/{id}', array('as' => 'desactiver_propriete', 'uses' => 'Admin_ProprieteController@desactiver'));

        Route::get('propriete/activer/{id}', array('as' => 'activer_propriete', 'uses' => 'Admin_ProprieteController@activer'));

        /**
         *
         * Deverifier/verifier annonce
         *
         **/

        Route::get('propriete/deverifier/{id}', array('as' => 'deverifier_propriete', 'uses' => 'Admin_ProprieteController@deverifier'));

        Route::get('propriete/verifier/{id}', array('as' => 'verifier_propriete', 'uses' => 'Admin_ProprieteController@verifier'));

        /**
         *
         * Home
         *
         **/

        Route::get('/', array('as' => 'getIndexAdmin', 'uses' => 'Admin_BaseController@index'));

        Route::get('deconnecter', array('as' => 'deconnexion', 'uses' => 'Admin_UserController@deconnecter'));


        Route::get('quitter', array('as' => 'leaveAdmin', 'uses' => 'Admin_UserController@leave'));


        /**
         *
         * CMS
         *
         **/

        /**
         *
         * @list
         *
         **/

        Route::resource('pages', 'Admin_PageController');
        /*Route::get('pages',array('as'=>'listPages','uses'=>'Admin_PageController@index'));*/

        /**
         *
         * Edit
         *
         **/


        /*Route::get('pages',array('as'=>'listPages','uses'=>'Admin_PageController@index'));*/

        Route::get('locations', array('as' => 'listLocations', 'uses' => 'Admin_ProprieteController@index'));

        Route::get('utilisateurs', array('as' => 'listUsers', 'uses' => 'Admin_UserController@index'));

        Route::get('database', array('as' => 'listDatabases', 'uses' => 'Admin_DatabaseController@index'));

        Route::get('traductions', array('as' => 'listTraductions', 'uses' => 'Admin_TraductionsController@index'));

    });
}); /*==========  END ADMIN  ==========*/