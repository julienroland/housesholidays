<?php

class InscriptionController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){

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

		Session::put('currentEtape', 1 );

		return View::make('inscription.index', array('page'=>'inscription_etape1'))
		->with(compact(array('paysList', 'regionList', 'sousRegionList')));

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

		/**
		*
		* Sauvegarde les inputs si jamais il refresh ou autre
		*
		**/
		Session::put('input_1',$input);
		
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
			* On se connecte au compte crée
			*
			**/
			Auth::login($user);

			/**
			*
			* Si l'étape d'inscription est complete on met true sinon false
			*
			**/	
			Session::put('etape1', true );
			Session::put('currentEtape', 1 );

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

			/**
			*
			* Redirige vers  l'étape suivante, on passe l'info de success
			*
			**/
			return Redirect::route('etape1Index', Auth::user()->slug)
			->with(array('success'=>trans('validation.custom.step1')));

		}
		else{

			Session::put('currentEtape', 1 );

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
	public function indexBatiment( ){


			/**
			*
			* Vérifie que l'utilisateur est bien connecté
			*
			**/

			if(Auth::check()){

				/**
				*
				* Preparation des array pour les selects
				*
				**/
				$listOption = Option::getListForm();

				$typeBatimentList = TypeBatiment::getListForm();

				Session::put('currentEtape', 2 );

				return View::make('inscription.etape2',array('page'=>'inscription_etape2'))
				->with(compact(array('typeBatimentList','listOption')));
			}
			else{
				Session::put('currentEtape', 2 );
				Session::put('etape1',false);
				return Redirect::to(trans('routes.inscription'))
				->with('compte',trans('compte.compte_inexistant'));
			}

		}

		public function saveBatiment(  ){

			$input = Input::all();

			$data = array(

				'titre_propriete'=> $input['titre_propriete'],
				'nom_propriete'=> $input['nom_propriete'],
				'type_propriete'=> $input['type_propriete'],
				'nb_personne'=> $input['nb_personne'],
				'nb_chambre'=> $input['nb_chambre'],
				'etage'=> $input['etage'],
				'taille_interieur'=> $input['taille_interieur'],
				'nb_sdb'=> $input['nb_sdb'],
				'taille_exterieur'=> $input['taille_exterieur'],
				'literie'=> (int)$input['literie'],

				);

			Session::put('input_2', $input );

			$validation = Validator::make($data, Propriete::$rules);

			if( $validation->passes() ) {
				/*dd($input);*/

			/**
			*
			* If ok, je push dans la DB, je met la session sur true et je redirige avec message de success
			*
			**/

			$user = User::find(Auth::user()->id);

			/**
			*
			* Ajout des champs de la table propriete
			*
			**/
			$propriete = new Propriete();

			$propriete->nb_personne = $input['nb_personne'];
			$propriete->nb_chambre = $input['nb_chambre'];
			$propriete->nb_sdb = $input['nb_sdb'];
			$propriete->taille_bien = $input['taille_interieur'];
			$propriete->taille_terrain = $input['taille_exterieur'];
			$propriete->etage = $input['etage'];
			$propriete->type_batiment_id = $input['type_propriete'];
			$propriete->annonce_payee_id = 1;
			$user->commentaire_statut = 1;
			$user->etape = Helpers::isOk(Propriete::getCurrentStep()) ? Propriete::getCurrentStep() : 1;
			$propriete->nom = $input['nom_propriete'];

			/**
			*
			* Ajout de l'id de relation entre user et propriete
			* @user hasMany propriete 
			* @proriete belongsTo user 
			*
			**/
			
			$propriete = $user->propriete()->save($propriete);

			
			/**
			*
			* Recup des arrays, suppression des lignes vides pour certains plus ajout de type integer
			*
			**/
			
			$literies = array_filter(array_map('intval',$input['literie']));
			$interieurs = array_filter($input['interieur']);
			$exterieurs = array_filter($input['exterieur']);
			$descriptions = $input['description'];
			$titres = $input['titre_propriete'];

			/**
			*
			* Boucle sur les titres pour les ajouters dans la table de traduction
			*
			**/
			
			foreach($titres as $key => $titre){

				$proprieteTraduction = new ProprieteTraduction();
				$proprieteTraduction->cle = "titre";
				$proprieteTraduction->valeur = $titre;
				$proprieteTraduction->langage_id = $key;

				/**
				*
				* On crée la relation entre propriete et proprieteTraduction
				* @propriete hasMany proprieteTraduction
				* @proprieteTraduction belongsTo propriete
				*
				**/
				
				$proprieteTraduction = $propriete->proprieteTraduction()->save($proprieteTraduction);
			}	
			/**
			*
			* Boucle sur les descriptions pour les ajouters dans la table de traduction
			*
			**/
			foreach($descriptions as $key => $description){

				$proprieteTraduction = new ProprieteTraduction();
				$proprieteTraduction->cle = "description";
				$proprieteTraduction->valeur = $description;
				$proprieteTraduction->langage_id = $key;
				$proprieteTraduction = $propriete->proprieteTraduction()->save($proprieteTraduction);
			}

			/**
			*
			* Boucle sur les options de type lit pour ajouter leurs relation à la table pivot
			* @propriete belongsToMany option
			* @option belongsToMany propriete
			* @propriete_id
			* @option_id
			* @valeur
			*
			**/

			foreach( $literies as $key => $literie){

				$propriete->option()->attach($key , array('valeur'=>$literie) );
			}

			/**
			*
			* Boucle sur les options de type interieur pour ajouter leurs relation à la table pivot
			*
			**/

			foreach( $interieurs as $key => $interieur){

				$propriete->option()->attach($key );
			}

			/**
			*
			* Boucle sur les options de type exterieur pour ajouter leurs relation à la table pivot
			* @propriete belongsToMany option
			* @option belongsToMany propriete
			* @propriete_id
			* @option_id
			* @valeur
			*
			**/

			foreach( $exterieurs as $key => $exterieur){

				$propriete->option()->attach($key);
			}

			Session::put('proprieteId', $propriete->id);

			/**
			*
			* Traduction: titre annonce, description
			*
			**/

			/**
			*
			* Etape finie
			*
			**/
			Session::put('etape2',true);
			Session::put('currentEtape', 2 );

			return Redirect::route( 'etape2Index' , Auth::user()->slug )
			->with(array('success',Lang::get('validation.custom.step2')));

		}
		else
		{

			Session::put('etape2',false);
			Session::put('currentEtape', 2 );
			return Redirect::route( 'etape2Index', Auth::user()->slug )
			->withInput()
			->withErrors($validation);

		}

	}
	public function updateLocalisation(){
		dd(Input::all());
	}
	/*-----  End of ETAPE 2  ------*/
		/*==============================
		=            ETAPE3            =
		==============================*/
		
		public function indexLocalisation(){


			$paysList = Pays::getListForm();

			$regionList = Region::getListForm();

			$sousRegionList = SousRegion::getListForm();

			$localiteList = Localite::getListForm();

			Session::put('currentEtape', 3 );

			return View::make('inscription.etape3', array('page'=>'inscription_etape3'))

			->with(compact(array('paysList','regionList','sousRegionList','localiteList')));

		}
		public function saveLocalisation(){

			$input = Input::all();

			Session::put('input_3', $input );

			Session::put('currentEtape', 3);

			dd($input);
		}
		
		/*-----  End of ETAPE3  ------*/
		
		
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
					return View::make('activation.index', array('page'=>'activation'))
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
				return View::make('activation.index', array('page'=>'activation'))
				->with(array(
					'validation'=>true,
					'user'=> $user
					));
			}
			else
			{
				return View::make('activation.index', array('page'=>'activation'))
				->with('validation',false);
			}

		}
		else
		{
			return View::make('activation.index', array('page'=>'activation'))
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