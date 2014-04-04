<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{

});


App::after(function($request, $response)
{
	//
});

use Illuminate\Database\Eloquent\ModelNotFoundException;

App::error(function(ModelNotFoundException $e)
{

	return Response::make(Lang::get('general.introuvable'), 404);
});

/**
*
* Filtre de langue
*
**/
Route::filter('lang', function(){

	$lang = Request::segment(1);

	if (in_array($lang, Config::get('app.available_locales')))
	{

		Session::put('lang',$lang );
		Session::put('langId', Langage::whereInitial($lang)->first(['id'])->id);	
		if(App::getLocale() !== $lang){

			App::setLocale($lang);

			if(Helpers::isOk(Route::currentRouteName()))
			{

				return Redirect::to($lang.'/'.Lang::get('routes.'.Route::currentRouteName()));

			}
			else{
				return Redirect::to('/');
			}
		}


	}
	else 
	{
		$langNav = Request::server('HTTP_ACCEPT_LANGUAGE');

		if (helpers::isOk($langNav)) 
		{
			$langue = explode(',',$langNav);
			$langue = strtolower(substr(chop($langue[1]),0,2));

			if (in_array($langue, Config::get('app.available_locales')))
			{
				Session::put('lang',$langue );
				Session::put('langId',Langage::whereInitial($langue)->first(['id'])->id);
				App::setLocale($langue);
				$lang = null;
			}
			else
			{
				$lang = null;
			}

		}
		else
		{

			$lang = null;

		}
	}

});
/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{	

	if (Auth::guest() && Helpers::isNotOk(Cookie::get('remember'))){ 

		return Redirect::guest(Lang::get('routes.connexion')); 

	}elseif(Auth::guest() && Helpers::isOk(Cookie::get('remember'))){

		return Redirect::action('ConnexionController@connectUser', Cookie::get('remember')); 
	};
});

Route::filter('inscription_propriete', function()
{	

	if (!Session::has('proprieteId') && Helpers::isNotOk( Session::get('proprieteId'))){ 

		return Redirect::to(Lang::get('routes.compte')); 

	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{

	if (Auth::check()){ 

		return Redirect::to(trans('routes.index'));

	}elseif(!Auth::check() && Helpers::isOk(Cookie::get('remember'))){ 

		if(Auth::attempt(array('email'=>Cookie::get('remember')['email'], 'password'=> Cookie::get('remember')['password']), isset(Cookie::get('remember')['remember']) ? true: false)) {

			Auth::login(Auth::user());
			return Redirect::route('compte', Auth::user()->slug)
			->with('success',trans('validation.custom.connect'));
			/**
			
				TODO:
				- probleme avec la redirection  
				- Second todo item
			
			**/
			
		}
		else{

				/**
				*
				* On revient a la page de connexion avec les bonnes valeurs entrées et les erreurs
				*
				**/
				Cookie::forget('remember');

			}

		};
	});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});