<?php

class InscriptionController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){

		/**
		*
		* On check si l'étape 1 est pas déjà faite, si oui on redigire sur l'étape 2
		*
		**/
		if(Session::get('etape1')){

			return Redirect::to(Lang::get('routes.inscription').'/'.Lang::get('routes.i_etape1'));

		}
		else{
			$paysList = Pays::getListForm();

			$regionList = Region::getListForm();

			$sousRegionList = SousRegion::getListForm();

		/**
		*
		* Redirection vers l'étape 1, on passe également toute les données utiles. 
		*
		**/

		/**
		*
		* compact('nom')  = $nom = XXXXX; Redirect::to('route')->with( 'nom' ,  $nom )
		*
		**/
		
		return View::make('inscription.index')
		->with(compact(array('paysList', 'regionList', 'sousRegionList')));
	}

}

/*===============================
=            ETAPE 1            =
===============================*/
public function saveUser(){

		/**
		*
		* Recup all input envoyé; Test de validation de la règle du modele User, 
		*
		**/
		$input = Input::all();
		/*Session::put('input', $input);*/
		$rules = User::$rules;
		$rules['check_password'] = 'same:password|required';
		$rules['cgv'] = 'accepted';

		$validation = Validator::make($input,$rules);
		/**
		*
		* Si valide
		*
		**/
		if($validation->passes()){

			/**
			*
			* Création d'un nouvelle user
			*
			**/
			$user = new User();

			$user->prenom = $input['prenom'];
			$user->nom = $input['nom'];
			$user->email = $input['email'];
			$user->pays_id = (int)$input['pays'];
			$user->password = Hash::make($input['password']);
			$user->key = sha1(mt_rand(10000,99999).date('dmyhms').$user->email);
			$user->save();

			/**
			*
			* Si l'étape d'inscription est complete on met true sinon false
			*
			**/	
			Session::put('etape1', true );

			/**
			*
			* Envoie de l'email de confirmation
			*
			**/
			Mail::queue('emails.bienvenue', array($input, $user), function($message) use($user)
			{
				$message->from('noreply@Housesholidays.com', 'Housesholidays');
				$message->to($user->email, $user->prenom . ' ' . $user->nom)
				->subject('Bienvenue sur Housesholidays!');
			});

			return Redirect::to(Lang::get('routes.inscription').'/'.Lang::get('routes.i_etape1'))
			->with(array('success'=>trans('validation.custom.step1')));

		}
		else{

			/**
			*
			* Retourne d'où on vient, on passe les inputs et les errors
			*
			**/
			return Redirect::to(trans('routes.inscription'))
			->withInput()
			->withErrors($validation);


		}
	}

	/*-----  End of ETAPE 1  ------*/

	/*===============================
	=            ETAPE 2            =
	===============================*/
	public function saveBatiment( ){

		if(Session::has('etape2')){

		}
		else
		{
			$typeBatimentList = TypeBatiment::getListForm();
			$nombreList = array(
				'' => 'Choissisez une valeur');

			for($i=1; $i <= 20; $i++){

				array_push($nombreList, $i);
			}
			$nombreList2 = array(
				'' => 'Choissisez une valeur');

			for($i=0; $i <= 10; $i++){

				array_push($nombreList2, $i);
			}

			return View::make('inscription.etape2')
			->with(compact(array('typeBatimentList','nombreList','nombreList2')));
		}
		
	}

	/*-----  End of ETAPE 2  ------*/
	public function activation( $key ){

		/**
		*
		* Verif si la clé est existante ...
		*
		**/
		if(Helpers::isOk( $key )){

			/**
			*
			* Recherche de la clé, trouve ou retourne false
			*
			**/
			$userActive = User::whereKey( $key )->firstOrFail();

			if( $userActive ){

				/**
				*
				* Si le user n'est pas encore validé on valide
				*
				**/
				if(!$userActive->valide){

					$user = User::find($userActive->id);

					$user->valide = true;

					$user->save();
				}
				else{
					return View::make('activation.index')
					->with(array(
						'validation'=>false,
						'message'=> trans('validation.custom.account_already_active')
						));
				}
				/**
				*
				* Retourne la vue avec le bon message
				*
				**/
				return View::make('activation.index')
				->with(array(
					'validation'=>true,
					'user'=> $user
					));
			}
			else
			{
				return View::make('activation.index')
				->with('validation',false);
			}

		}
		else
		{
			return View::make('activation.index')
			->with(array('validation'=> false,
				'message'=>trans('validation.custom.key_invalid')));
		}
	}
	public function informationsPersos()
	{
		$input = Input::all();
		$rules = array(
			'first_name'=>'required',
			'last_name'=>'',
			'email'=>'email|required',
			'address'=>'required',
			'country'=>'required',
			'region'=>'required',
			'locality'=>'required',
			'sous_region'=>'required',
			'mother_tongue'=>'required',
			'password'=>'required|min:3',
			'check_password'=>'same:password|required',
			'cgv'=>'accepted',
			);

		$validation = Validator::make($input,$rules);
		if($validation->passes()){
			Session::put('user_etape1',$input);
			/*User::create(array(
				'nom'=>,
				'prenom'=>,
				'email'=>,
				'adresse'=>,
				'postal'=>,
				'password'=>,
				'slug'=>,
				));*/
return Redirect::route('inscription_etape2')
->with(array('success'=>'Vos informations de l\'étape précédente ont bien été enregistrées'));

}
else{
	return Redirect::route('inscription_etape1')
	->withInput()
	->withErrors($validation);


}
}

}