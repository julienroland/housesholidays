<?php

class ConnexionController extends BaseController {


	public function index( ) {


		return View::make('connexion.index', array('page'=>'connexion'));
	} 

	public function connectUser(  ){

		/**
		*
		* Tous les champs
		*
		**/
		$input = Input::all();


		/**
		*
		* Les règles de validation
		*
		**/
		$rules = array(
			'email'=>'required|exists:users,email|email|min:5',
			'password' => 'required|min:3|alpha_num',
			);

		/**
		*
		* Si valide
		*
		**/
		$validation = Validator::make( $input , $rules );

		if($validation->passes()){

			/**
			*
			* Tentative de connexion
			* @return boolean
			*
			**/

			if(Auth::attempt(array('email'=>$input['email'], 'password'=> $input['password']), isset($input['remember']) ? true: false)) {

				
				if(isset($input['remember'])){
					return Redirect::route('compte', Auth::user()->slug)
					->with('success',trans('validation.custom.connect'))
					->withCookie(Cookie::forever('remember', $input))
					->withCookie(Cookie::forever('email', $input['email']));
				}
				else
				{
					return Redirect::route('compte', Auth::user()->slug)
					->with('success',trans('validation.custom.connect'));
				}
			}
			else{
				
				/**
				*
				* On revient a la page de connexion avec les bonnes valeurs entrées et les erreurs
				*
				**/
				
				return Redirect::to(Lang::get('routes.connexion'))
				->withInput()
				->withErrors($validation);
			}
		}
		else
		{

			return Redirect::to(Lang::get('routes.connexion'))
			->withInput()
			->withErrors($validation);
		}

	}

	public function deconnecter(){

		if(Auth::check()){

			/**
			*
			* Deconnexion du user
			*
			**/
			Auth::logout();

			/**
			*
			* Suppression de toute les sessions
			*
			**/
			Session::flush();

			/**
			*
			* Suppression du cookie
			*
			**/
			

			$message = trans('validation.custom.disconnect');
		}
		else
		{
			$message = trans('validation.custom.already_disonnect');
		}

		return Redirect::to(trans('routes.index'))
		->withCookie(Cookie::forget('remember'))
		->with(compact('message'));
	}
}