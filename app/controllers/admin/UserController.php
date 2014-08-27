<?php

class Admin_UserController extends \Admin_BaseController
{
	public function index()
	{
		return View::make('admin.user.index');
	}

	public function connecter(  ){

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
					return Redirect::route('getIndexAdmin')
					->with('success',trans('validation.custom.connect'))
					->withCookie(Cookie::forever('remember', $input))
					->withCookie(Cookie::forever('rememberEmail', $input));
				}
				else
				{
					return Redirect::route('getIndexAdmin')
					->with('success',trans('validation.custom.connect'));
				}
			}
			else{

				/**
				*
				* On revient a la page de connexion avec les bonnes valeurs entrées et les erreurs
				*
				**/

				return Redirect::route('getIndexAdmin')
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
	public function deconnecter()
	{
		if(Auth::check()){

			Auth::logout();

			Session::flush();

			return Redirect::guest('/');
		}
		else{

			return Redirect::guest('/');

		}

	}

	public function leave()
	{
		return Redirect::to('/');
	}
}