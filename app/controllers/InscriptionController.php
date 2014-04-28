<?php

use Carbon\Carbon;

class InscriptionController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){

		$paysList = Pays::getListForm();

		$post = Page::with('pageTraduction')->whereHook('login')->first();

		/*$regionList = Region::getListForm();

		$sousRegionList = SousRegion::getListForm();*/

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

		return View::make('inscription.index', array('page'=>'inscription_etape1','widget'=>array('select')))
		->with(compact(array('paysList','post')));

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
		/*Session::put('input_1',$input);*/
		
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
			$user->role = 1;
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
			/*Mail::queue('emails.bienvenue', array($input, $user), function($message) use($user)
			{
				$message->from('noreply@Housesholidays.com', 'Housesholidays');
				$message->to($user->email, $user->prenom . ' ' . $user->nom)
				->subject('Bienvenue sur Housesholidays!');
			});*/

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
	/*====================================
	=            CHECKSESSION            =
	====================================*/

	public function checkSession(){

		if(Session::has('proprieteId')){

			Session::forget('proprieteId');

			Session::forget('currentEtape');
		}

		for( $i = 1; $i <= Config::get('var.etape'); $i++ ){

			if(Session::has('input_'.$i)){

				Session::forget('input_'.$i);
			}

			if(Session::has('etape'.$i)){

				Session::forget('etape'.$i);
			}
		}

		return Redirect::route('etape1Index', Auth::user()->slug);

	}
	
	
	/*-----  End of CHECKSESSION  ------*/
	
	
	/*-----  End of ETAPE 1  ------*/

	/*===============================
	=            ETAPE 2            =
	===============================*/
	public function indexBatiment( $data ){

		$edit = false;

		if(is_object($data) || Session::has('proprieteId')){

			
			if(!is_object($data)){

				$edit = false;
				$data = Propriete::findOrFail(Session::get('proprieteId'));

			}else{

				$edit = true;
			}

			$data = $data->with(array('option'))->whereId($data->id)->first();

			$titre =  ProprieteTraduction::getTitle( $data->id );
			$description = ProprieteTraduction::getDescription( $data->id );

			$options = Propriete::getOption( $data->id );

		}
		else{

			Session::forget('proprieteId');

		}

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

				if( $edit ){

					return View::make('inscription.etape2',array('page'=>'inscription_etape2','widget'=>array('select','tab')))
					->with(compact(array('typeBatimentList','listOption','data','edit','titre','description','options')));

				}
				else
				{	
					return View::make('inscription.etape2',array('page'=>'inscription_etape2','widget'=>array('select','tab')))
					->with(compact(array('typeBatimentList','listOption','data','edit','titre','description','options')));
				}
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

				'nom_propriete'=> $input['nom_propriete'],
				'titre_propriete'=> $input['titre_propriete'],
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

			$validation = Validator::make($data, Propriete::$rules1);

			if( $validation->passes() ) {
				

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
			$propriete->exposition = $input['exposition'];
			$propriete->commentaire_statut = 1;
			$propriete->etape = Helpers::isOk(Propriete::getCurrentStep()) ? Propriete::getCurrentStep() : 1;
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
			if(isset($input['literie'])){
				$literies = array_filter(array_map('intval',$input['literie']));
			}
			if(isset($input['interieur'])){
				$interieurs = $input['interieur'];
			}

			if(isset($input['exterieur'])){
				$exterieurs = array_filter($input['exterieur']);
			}
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
			if(isset($literies)){

				foreach( $literies as $key => $literie){

					$propriete->option()->attach($key , array('valeur'=>$literie) );
				}

			}
			/**
			*
			* Boucle sur les options de type interieur pour ajouter leurs relation à la table pivot
			*
			**/
			if(isset($interieurs)){

				foreach( $interieurs as $key => $interieur){

					$propriete->option()->attach($key, array('valeur' => $interieur) );
				}
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
			if(isset($exterieurs)){

				foreach( $exterieurs as $key => $exterieur){

					$propriete->option()->attach($key);
				}
			}
			if(!Session::has('proprieteId')){

				Session::put('proprieteId', $propriete->id);

			}else{

				Session::forget('proprieteId');
				Session::put('proprieteId', $propriete->id);				

			}

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
			return Redirect::route( 'etape1Index', Auth::user()->slug )
			->withInput()
			->withErrors($validation);

		}

	}
	public function updateBatiment( $id, $proprieteId = null ){

		if(Helpers::isNotOk( $proprieteId )){

			$proprieteId = $id->id;
		}

		
		$edit = false;

		if(is_object($id) && !Session::has('proprieteId')){

			$edit = true;
		}

		$input = Input::all();

		$data = array(

			'nom_propriete'=> $input['nom_propriete'],
			'titre_propriete'=> $input['titre_propriete'],
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

		$validation = Validator::make($data, Propriete::$rules1);

		if( $validation->passes() ) {
			
			$propriete = Propriete::find( $proprieteId );
			$user = Auth::user();

			$propriete->nb_personne = $input['nb_personne'];
			$propriete->nb_chambre = $input['nb_chambre'];
			$propriete->nb_sdb = $input['nb_sdb'];
			$propriete->taille_bien = $input['taille_interieur'];
			$propriete->taille_terrain = $input['taille_exterieur'];
			$propriete->etage = $input['etage'];
			$propriete->type_batiment_id = $input['type_propriete'];
			$propriete->exposition = $input['exposition'];
			$propriete->annonce_payee_id = 1;
			$user->commentaire_statut = 1;
			
			$user->etape = Helpers::isOk(Propriete::getCurrentStep()) ? Propriete::getCurrentStep() : 1;
			$propriete->nom = $input['nom_propriete'];

			$propriete->save();

			/**
			*
			* Recup des arrays, suppression des lignes vides pour certains plus ajout de type integer
			*
			**/
			
			if(isset($input['literie'])){
				$literies = array_filter(array_map('intval',$input['literie']));
			}
			if(isset($input['interieur'])){
				$interieurs = $input['interieur'];
			}
			if(isset($input['exterieur'])){
				$exterieurs = array_filter($input['exterieur']);
			}
			$descriptions = $input['description'];
			$titres = $input['titre_propriete'];

			/**
			*
			* Boucle sur les titres pour les ajouters dans la table de traduction
			*
			**/

			ProprieteTraduction::whereProprieteId($propriete->id)->whereCle('titre')->delete();
			
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
			ProprieteTraduction::whereProprieteId($propriete->id)->whereCle('description')->delete();

			foreach($descriptions as $key => $description){

				$proprieteTraduction = new ProprieteTraduction();
				$proprieteTraduction->cle = "description";
				$proprieteTraduction->valeur = $description;
				$proprieteTraduction->langage_id = $key;
				$proprieteTraduction = $propriete->proprieteTraduction()->save($proprieteTraduction);
			}

			/**
			*
			* On detach les options de l'étape2 on les rataches ensuite
			*
			**/
			
			$typeOptions  = TypeOption::whereId(3)->with('enfant')->first();

			$listOption = array();

			foreach($typeOptions->enfant as $typeOption){

				foreach($typeOption->option()->get() as $option){

					array_push($listOption, $option->id);
				}

			}

			
			foreach($listOption as $option){

				$propriete->option()->detach( $option );
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

			if(isset($literies)){

				foreach( $literies as $key => $literie){

					$propriete->option()->attach($key , array('valeur'=>$literie) );
				}

			}
			/**
			*
			* Boucle sur les options de type interieur pour ajouter leurs relation à la table pivot
			*
			**/

			if(isset($interieurs)){

				foreach( $interieurs as $key => $interieur){

					$propriete->option()->attach($key , array('valeur'=>$interieur));
				}
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
			if(isset($exterieurs)){

				foreach( $exterieurs as $key => $exterieur){

					$propriete->option()->attach($key);
				}
			}

			Session::put('etape2',true);
			Session::put('currentEtape', 2 );

			if( $edit ){

				return Redirect::route( 'editPropriete2' , $propriete->id )
				->with(array('success',Lang::get('validation.custom.step2')));

			}else{

				return Redirect::route( 'etape2Index' , Auth::user()->slug )
				->with(array('success',Lang::get('validation.custom.step2')));

			}
		}else{

			Session::put('etape1',false);
			Session::put('currentEtape', 2 );

			if($edit){

				return Redirect::route( 'editPropriete1', $data->id )
				->withInput()
				->withErrors($validation);

			}else{

				return Redirect::route( 'etape1Index', Auth::user()->slug )
				->withInput()
				->withErrors($validation);

			}
		}
	}
	/*-----  End of ETAPE 2  ------*/

		/*==============================
		=            ETAPE3            =
		==============================*/
		
		public function indexLocalisation(  $data = null){

			$edit = false;

			if(is_object($data) || Session::has('proprieteId')){

				if(!is_object($data)){

					$edit = false;

					$data = Propriete::findOrFail(Session::get('proprieteId'));

				}else{

					$edit = true;
				}

				$paysId = $data->pays_id;

				$regionId = $data->region_id;

				$sousRegionId = $data->sous_region_id;

				$localiteId = $data->localite_id;

				$situations = Propriete::find($data->id)->option()->whereOptionId(44)->get()->toArray();

				$latlng = Propriete::find($data->id)->latlng;

				$distanceData = Propriete::find($data->id)->option()->whereOptionId(45)->first();

				if(Helpers::isOk($distanceData)){

					$distanceData = $distanceData->pivot->valeur;
				}

				$situationData = array();

				foreach($situations as $situation){
					
					array_push($situationData, $situation['pivot']['valeur']);

				}

			}	

			/**
			*
			* Preparation des listes pour les selects
			*
			**/
			
			$paysList = Pays::getListForm();

			$regionList = Region::getListForm();

			$sousRegionList = SousRegion::getListForm();

			$localiteList = Localite::getListForm();
			
			$situationList = Option::getListForm('etape_3')->situation;

			/**
			*
			* Avoir les id des options pour situations et distances
			*
			**/

			$situationId = Option::getListForm('etape_3')->situationId;

			$distanceId = Option::getListForm('etape_3')->distanceId;

			/**
			*
			* On est toujours à l'étape 3
			*
			**/
			
			Session::put('currentEtape', 3 );

			if( $edit && !Session::has('proprieteId') ){

				return View::make('inscription.etape3', array('page'=>'inscription_etape3','widget'=>array('select')))

				->with(compact(array('paysList','regionList','sousRegionList','localiteList','situationList','data','situationId','distanceId','paysId','regionId','sousRegionId','localiteId','situation','situationData','distanceData','latlng')));

			}else{

				return View::make('inscription.etape3', array('page'=>'inscription_etape3','widget'=>array('select')))

				->with(compact(array('paysList','regionList','sousRegionList','localiteList','situationList','situationId','data','distanceId','paysId','regionId','sousRegionId','localiteId','situation','situationData','distanceData','latlng')));

			}

		}

		public function saveLocalisation(){


			/**
			*
			* Get all input
			*
			**/
			
			$input = Input::all();

			/**
			*
			* On ajout les inputs à la session
			*
			**/
			
			/*Session::put('input_3', $input );*/

			/**
			*
			* On est toujours à l'étape 3
			*
			**/
			
			Session::put('currentEtape', 3);

			$validation = Validator::make( $input , Propriete::$rules2 );

			if( $validation->passes() ){

				/**
				*
				* Trouvé la propriete en question via l'id stocké
				*
				**/

				$propriete = Propriete::find( Session::get('proprieteId') );

				/**
				*
				* On met à jour
				*
				**/
				
				$propriete->pays_id = $input['pays'];
				$propriete->region_id = $input['region'];
				$propriete->sous_region_id = $input['sous_region'];
				$propriete->localite_id = $input['localite'];
				$propriete->adresse = $input['adresse'];
				$propriete->latlng = $input['latlng'];
				$propriete->etape = Helpers::isOk(Propriete::getCurrentStep()) ? Propriete::getCurrentStep() : 2;

				/**
				*
				* On sauvegarde les modifications
				*
				**/
				
				$propriete->save();

				Sluggable::make($propriete,true);

				$propriete->save();
				/**
				*
				* On attach les clés étrangère dans la table pivot option_propriete
				*
				**/
				
				$propriete->option()->attach( $input['distanceId'] , array('valeur'=> $input['distance'] ) );

				foreach( $input['situation'] as $situation){

					$propriete->option()->attach( $input['situationId'] , array('valeur'=> $situation ) );

				}

				/**
				*
				* Si a resort bien quelque chose
				*
				**/
				
				if(Helpers::isOk( $propriete )){

					/**
					*
					* L'étape est finie
					*
					**/
					
					Session::put('etape3', true);

					/**
					*
					* Etape suivante avec message de success
					*
					**/
					
					return Redirect::route('etape3Index', Auth::user()->slug)
					->with(array('success',Lang::get('validation.custom.step3')));
				}
			}
			else
			{


				Session::put('etape3',false);
				Session::put('currentEtape', 3 );
				return Redirect::route( 'etape2Index', Auth::user()->slug )
				->withInput()
				->withErrors($validation);
			}
			
		}

		public function updateLocalisation( $data = null){

			$edit = false;

			if(is_object($data)){

				$edit = true;
			}
			/**
			*
			* Get all input
			*
			**/
			
			$input = Input::all();

			/**
			*
			* On ajout les inputs à la session
			*
			**/
			
			/*Session::put('input_3', $input );*/

			/**
			*
			* On est toujours à l'étape 3
			*
			**/
			
			Session::put('currentEtape', 3);

			$validation = Validator::make( $input , Propriete::$rules2 );

			if( $validation->passes() ){
				
				/**
				*
				* Trouvé la propriete en question via l'id stocké
				*
				**/
				if(isset($data) && is_object($data)){

					$propriete = $data;

				}else{

					$propriete = Propriete::find( Session::get('proprieteId') );

				}

				/**
				*
				* On met à jour
				*
				**/
				
				$propriete->pays_id = $input['pays'];
				$propriete->region_id = $input['region'];
				$propriete->sous_region_id = $input['sous_region'];
				$propriete->localite_id = $input['localite'];
				$propriete->adresse = $input['adresse'];

				if(isset($input['latlng']) && Helpers::isOk($input['latlng'])){

					$propriete->latlng = $input['latlng'];

				}

				$propriete->etape = Helpers::isOk(Propriete::getCurrentStep()) ? Propriete::getCurrentStep() : 2;
				
				/**
				*
				* On sauvegarde les modifications
				*
				**/
				
				$propriete->save();

				Sluggable::make( $propriete, true );

				$propriete->save();


				/**
				*
				* On attach les clés étrangère dans la table pivot option_propriete
				*
				**/
				//id 13 = localisation
				$typeOption  = TypeOption::find(13);

				$listOption = $typeOption->option()->get();

				foreach($listOption as $option){

					$propriete->option()->detach( $option->id );
				}
				
				$propriete->option()->attach( $input['distanceId'] , array('valeur'=> $input['distance'] ) );

				foreach( $input['situation'] as $situation){

					$propriete->option()->attach( $input['situationId'] , array('valeur'=> $situation ) );

				}

				/**
				*
				* Si a resort bien quelque chose
				*
				**/
				
				if(Helpers::isOk( $propriete )){
					
					Sluggable::make($propriete,true);

					$propriete->save();


					/**
					*
					* L'étape est finie
					*
					**/
					
					Session::put('etape3', true);

					/**
					*
					* Etape suivante avec message de success
					*
					**/

					if($edit){

						return Redirect::route('editPropriete3', $data->id)
						->with(array('success',Lang::get('validation.custom.step3')));

					}else{

						return Redirect::route('etape3Index', Auth::user()->slug)
						->with(array('success',Lang::get('validation.custom.step3')));

					}
				}
			}
			else
			{

				Session::put('etape3',false);
				Session::put('currentEtape', 3 );

				if($edit){

					return Redirect::route( 'editPropriete2', $data->id )
					->withInput()
					->withErrors($validation);

				}else{

					return Redirect::route( 'etape2Index', Auth::user()->slug )
					->withInput()
					->withErrors($validation);

				}
			}
			
		}
		
		/*-----  End of ETAPE3  ------*/


		/*===============================
		=            ETAPE 4            =
		===============================*/
		public function indexPhoto( $data ){

			$edit = false;

			if(is_object($data) || Session::has('proprieteId')){


				if(!is_object($data)){

					$edit = false;
					$data = Propriete::findOrFail(Session::get('proprieteId'));

				}else{

					$edit = true;
				}

				
			}

			if(is_object($data)){

				$photosPropriete = Propriete::getPhoto( $data->id, Config::get('var.image_thumbnail'));

			}else{

				$photosPropriete = Propriete::getPhoto( Session::get('proprieteId'), Config::get('var.image_thumbnail'));

			}

			Session::put('currentEtape', 4 );

			if($edit){

				return View::make('inscription.etape4', array('page'=>'inscription_etape4','widget'=>array('sortable','upload')))
				->with(compact('photosPropriete','data'));

			}else{

				return View::make('inscription.etape4', array('page'=>'inscription_etape4','widget'=>array('sortable','upload')))
				->with(compact('photosPropriete','data'));

			}
		}
		
		public function savePhoto(){

			$input = Input::all();
			$orders = (array)json_decode($input['image_order']);
			$rules = array('video'=>'url');

			$validation  = Validator::make($input, $rules);

			if( $validation ){
				
				foreach($orders as $key => $order){

					$photo = PhotoPropriete::find($key);	

					if($order == 1){

						$photo->accroche = 1;
					}
					
					$photo->ordre = $order;
					$photo->save();
				}

				$propriete = Propriete::find(Session::get('proprieteId'));
				$propriete->video = $input['video'];
				$propriete->save();

				/*Session::put('input_4', $input);*/
				Session::put('etape4',true);
				Session::put('currentEtape', 4 );

				return Redirect::route('etape4Index',Auth::user()->slug)
				->with(array('success',Lang::get('validation.custom.step4')));
			}
			else
			{

				Session::put('etape4',false);
				Session::put('currentEtape', 4 );
				return Redirect::route( 'etape3Index', Auth::user()->slug )
				->withInput()
				->withErrors($validation);
			}

		}

		public function updatePhoto($data){

			$edit = false;

			if(is_object( $data )){

				$edit = true;

			}

			$input = Input::all();
			$orders = (array)json_decode($input['image_order']);
			$rules = array('video'=>'url');

			$validation  = Validator::make($input, $rules);

			if( $validation ){
				
				foreach($orders as $key => $order){

					$photo = PhotoPropriete::find($key);	

					if($order == 1){

						$photo->accroche = 1;
					}
					
					$photo->ordre = $order;
					$photo->save();
				}
				if($edit){

					$propriete = $data;

				}else{

					$propriete = Propriete::find(Session::get('proprieteId'));

				}

				$propriete->video = $input['video'];
				$propriete->save();

				/*Session::put('input_4', $input);*/
				Session::put('etape4',true);
				Session::put('currentEtape', 4 );
				if( $edit ){

					return Redirect::route('editPropriete4', $data->id)
					->with(array('success',Lang::get('validation.custom.step4')));

				}else{

					return Redirect::route('etape4Index',Auth::user()->slug)
					->with(array('success',Lang::get('validation.custom.step4')));
				}
			}
			else
			{

				Session::put('etape4',false);
				Session::put('currentEtape', 4 );

				if($edit){

					return Redirect::route( 'editPropriete3', $data->id )
					->withInput()
					->withErrors($validation);

				}else{

					return Redirect::route( 'etape3Index', Auth::user()->slug )
					->withInput()
					->withErrors($validation);

				}
			}

		}
		/*-----  End of ETAPE 4  ------*/
		
		/*==============================
		=            ETAPE5            =
		==============================*/
		
		public function indexTarif( $data ){

			$edit = false;

			if(is_object($data) || Session::has('proprieteId')){
				/*Session::forget('input_3');*/

				if(!is_object($data)){

					$edit = false;
					$data = Propriete::findOrFail(Session::get('proprieteId'));

				}else{

					$edit = true;
				}


			}

			$nuits = array(
				''=>''
				);

			for( $i = 1; $i < Config::get('var.nb_nuits'); $i++){
				$nuits[$i] = $i.' '.Lang::get('general.nuits');
			}

			$monnaies = Monnaie::getList(  );

			$jours = JourSemaine::getList();

			if($edit){

				$tarifs = Tarif::with(array('monnaie','tarifSpeciauxWeekend'))->where('propriete_id',$data->id)->orderBy('id','asc')->get();

			}else{

				$tarifs = Tarif::with(array('monnaie','tarifSpeciauxWeekend'))->where('propriete_id',Session::get('proprieteId'))->orderBy('id','asc')->get();
			}

			Session::put('currentEtape', 5 );

			if($edit){

				return View::make('inscription.etape5', array('page'=>'inscription_etape5','widget'=>array('datepicker','select')))
				->with(compact('nuits','monnaies','jours','tarifs','data'));

			}else{

				return View::make('inscription.etape5', array('page'=>'inscription_etape5','widget'=>array('datepicker','select')))
				->with(compact('nuits','monnaies','jours','tarifs','data'));

			}
		}
		/**
		*
		* Ajout des tarifs
		* @ajax
		*
		**/
		
		public function addTarif(  ){			

			$input = Input::all();

			/**
			*
			* On ajout les inputs à la session
			*
			**/
			
			/*Session::put('input_5', $input );*/

			/**
			*
			* On est toujours à l'étape 5
			*
			**/
			
			Session::put('currentEtape', 5);

			if(isset($input['proprieteId']) && Helpers::isOk($input['proprieteId'])){

				$propriete = Propriete::find((int)$input['proprieteId']);

			}
			else{

				$propriete = Propriete::find(Session::get('proprieteId'));

			}

			if(isset($input['monnaie']) && Helpers::isOk($input['monnaie'])){

				$monnaie = Monnaie::find( (int)$input['monnaie'] );

			}

			$tarif = new Tarif;

			$tarif->date_debut = Helpers::toServerDate( $input['debut'] );
			$tarif->date_fin = Helpers::toServerDate( $input['fin'] );
			$tarif->duree_min = $input['min_nuit'];
			$tarif->saison = $input['nom_saison'];
			$tarif->prix_nuit = $input['nuit'];
			$tarif->prix_semaine = $input['semaine'];
			$tarif->prix_mois = $input['mois'];
			$tarif->disponibilite = 1;
			$tarif->prix_weekend = $input['prix_weekend']; 

			if(isset($input['arrive']) && Helpers::isOk( $input['arrive'])){

				$tarif->jour_arrive_id = $input['arrive'];

			}
			$tarif->monnaie_id = $input['monnaie'];

			if(Helpers::isOk( $tarif->weekend )){

				$tarif->prix_weekend = $input['prix_weekend'];

			}

			$tarif = $propriete->tarif()->save($tarif);
			$tarif = $monnaie->tarif()->save($tarif);
			if(isset($input['duree_supp']) && Helpers::isOK( $input['duree_supp'] )){
				$tarifSpeciaux = new TarifSpeciauxWeekend;

				$tarifSpeciaux->max_nuit = $input['nuit_max'];

				$tarifSpeciaux->save();	

				$tarif = $tarifSpeciaux->tarif()->save($tarif);
			}

			if(isset( $input['jour_weekend'] ) && Helpers::isOk( $input['jour_weekend'] )){

				foreach( $input['jour_weekend'] as $key => $jour ){

					$tarifSpeciaux->jourSemaine()->save( $tarifSpeciaux , array('jour_semaine_id'=>$key));


				}
			}

			$tarif->save();

			if(isset($input['proprieteId']) && Helpers::isOk($input['proprieteId'])){

				$propriete = Propriete::find((int)$input['proprieteId']);

			}
			else{

				$propriete = Propriete::find(Session::get('proprieteId'));

			}
			

			$propriete->etape = Helpers::isOk(Propriete::getCurrentStep()) ? Propriete::getCurrentStep() : 5;

			$propriete->save();

			if(Helpers::isOk($tarif)){

				return Response::json($tarif->with(array('monnaie','tarifSpeciauxWeekend'))->where('propriete_id',$propriete->id)->orderBy('id','desc')->get(), 200);

			} else {

				return Response::json('error', 400);
			}

		}
		public function updateTarif( ){			

			$input = Input::all();
			

			if(isset($input['monnaie']) && Helpers::isOk($input['monnaie'])){

				$monnaie = Monnaie::find( (int)$input['monnaie'] );

			}

			$tarif = Tarif::find($input['tarifId']);
			$propriete = $tarif->propriete()->first();

			$tarif->date_debut = Helpers::toServerDate( $input['debut'] );
			$tarif->date_fin = Helpers::toServerDate( $input['fin'] );
			$tarif->duree_min = $input['min_nuit'];
			$tarif->saison = $input['nom_saison'];
			$tarif->prix_nuit = $input['nuit'];
			$tarif->prix_semaine = $input['semaine'];
			$tarif->prix_mois = $input['mois'];
			$tarif->prix_weekend = $input['prix_weekend_popup']; 

			if(isset($input['arrive_popup']) && Helpers::isOk( $input['arrive_popup'])){

				$tarif->jour_arrive_id = $input['arrive_popup'];

			}
			$tarif->monnaie_id = $input['monnaie'];

			$tarif = $propriete->tarif()->save($tarif);
			$tarif = $monnaie->tarif()->save($tarif);

			$tarifSpeciaux = TarifSpeciauxWeekend::find($input['weekendId']);

			if(isset($input['weekend_popup']) && Helpers::isOK( $input['weekend_popup'] )){

				
				if(isset($input['duree_supp_popup']) && Helpers::isOK( $input['duree_supp_popup'] ) || isset( $input['jour_weekend_popup'] ) && Helpers::isOk( $input['jour_weekend_popup'] )){

					if(Helpers::isNotOk( $tarifSpeciaux )){

						$tarifSpeciaux = new TarifSpeciauxWeekend;

						$tarifSpeciaux->save();

					}

				}else{

					$tarif->tarif_special_weekend_id = null;

					if(Helpers::isOk( $tarifSpeciaux )){

						if(Helpers::isOk($tarifSpeciaux) && $tarifSpeciaux->jourSemaine()->get()){

							$tarifSpeciaux->jourSemaine()->detach();
						}

						$tarifSpeciaux->delete();
					}
				}
				if(isset($input['duree_supp_popup']) && Helpers::isOK( $input['duree_supp_popup'] )){

					$tarifSpeciaux->max_nuit = $input['nuit_max_popup'];

					$tarifSpeciaux->save();	

					$tarif = $tarifSpeciaux->tarif()->save($tarif);
				}

				if(isset( $input['jour_weekend_popup'] ) && Helpers::isOk( $input['jour_weekend_popup'] )){

					$tarifSpeciaux->jourSemaine()->detach();

					foreach( $input['jour_weekend_popup'] as $key => $jour ){

						$tarifSpeciaux->jourSemaine()->save( $tarifSpeciaux , array('jour_semaine_id'=>$key));


					}
				}
				
				
			}
			else{

				$tarif->tarif_special_weekend_id = null;
				
				$tarif->save();

				if(Helpers::isOk($tarifSpeciaux) && $tarifSpeciaux->jourSemaine()->get()){

					$tarifSpeciaux->jourSemaine()->detach();
				}


				$tarifSpeciaux->delete();
			}

			

			$propriete = $tarif->propriete()->first();

			$propriete->etape = Helpers::isOk(Propriete::getCurrentStep()) ? Propriete::getCurrentStep() : 5;

			$propriete->save();

			if(Helpers::isOk($tarif)){

				return Response::json($tarif->with(array('monnaie','tarifSpeciauxWeekend'))->where('propriete_id',$propriete->id)->orderBy('id','desc')->get(), 200);

			} else {

				return Response::json('error', 400);
			}

		}
		public function deleteTarif( $id ){
			
			$tarif = Tarif::find($id);
			
			$propriete = $tarif->propriete()->first();

			$tarifSpeciauxWeekend = $tarif->tarifSpeciauxWeekend()->first();

			if( $tarifSpeciauxWeekend ){

				$tarifSpeciauxWeekend->jourSemaine()->detach();

			}

			$tarif = $tarif->delete();

			if( $tarifSpeciauxWeekend ){

				$tarifSpeciauxWeekend->delete();

			}
			
			if(Helpers::isOk($tarif)){

				$tarifs = Tarif::with(array('monnaie','tarifSpeciauxWeekend'))->where('propriete_id',$propriete->id)->orderBy('id','desc')->get();
				if(Helpers::isOk( $tarifs )){

					return Response::json($tarifs, 200);	

				}

				return Response::json('', 200);
			}
			else{

				return Response::json('error',400);
			}
		}
		public function saveTarif(  ){

			$input = Input::all();

			/**
			*
			* On ajout les inputs à la session
			*
			**/
			
			/*Session::put('input_5bis', $input );*/

			/**
			*
			* On est toujours à l'étape 5
			*
			**/
			
			Session::put('currentEtape', 5);

			$rules = array(
				'nettoyage'=>'numeric',
				'acompte'=>'numeric',
				);

			$validation = Validator::make( $input, $rules );

			if( $validation ){

				$propriete = Propriete::find(Session::get('proprieteId'));

				$propriete->caution = $input['accompte'];
				$propriete->condition_paiement = $input['conditions'];
				$propriete->nettoyage = $input['nettoyage'];
				$propriete->etape = Propriete::getCurrentStep();

				$propriete->save();

				Session::put('etape5',true);

				if( $propriete ){

					return Redirect::route('etape5Index',Auth::user()->slug)
					->with(array('success'=>trans('validation.custom.step5')));
				}
				else
				{	
					Session::put('etape5',false);

					return Redirect::route('etape5Index',Auth::user()->slug)
					->withInput()
					->withErrors($validation);
				}
			}
		}
		public function updateTarif2( $data ){
			
			$input = Input::all();

			/**
			*
			* On ajout les inputs à la session
			*
			**/
			
			/*Session::put('input_5bis', $input );*/

			/**
			*
			* On est toujours à l'étape 5
			*
			**/
			
			Session::put('currentEtape', 5);

			$rules = array(
				'nettoyage'=>'numeric',
				'acompte'=>'numeric',
				);

			$validation = Validator::make( $input, $rules );

			if( $validation ){

				if(is_object($data)){

					$propriete = $data;

				}else{

					$propriete = Propriete::find(Session::get('proprieteId'));

				}

				$propriete->caution = $input['accompte'];
				$propriete->condition_paiement = $input['conditions'];
				$propriete->nettoyage = $input['nettoyage'];
				$propriete->etape = Propriete::getCurrentStep();

				$propriete->save();

				Session::put('etape5',true);

				if( is_object( $data )){

					return Redirect::route('editPropriete5', $data->id)
					->with(array('success'=>trans('validation.custom.step5')));
				}
				else
				{	
					Session::put('etape5',false);

					return Redirect::route('etape5Index',Auth::user()->slug)
					->withInput()
					->withErrors($validation);
				}
			}
		}

		public function getOneTarif( $id ){

			return Tarif::with(array('monnaie','tarifSpeciauxWeekend.jourSemaine'))->whereId($id)->first();

		}

		/*-----  End of ETAPE5  ------*/


		/*===============================
		=            ETAPE 6            =
		===============================*/
		public function indexDisponibilite($data){

			$currentDate = Carbon::now(); 

			$edit = false;
			
			if(!is_object($data)){

				$data = Calendrier::whereProprieteId( Session::get('proprieteId') )->get();
				
				$edit = true;

			}else{

				$edit = false;

			}

			$date = date('n');
			return View::make('inscription.etape6', array('page'=>'inscription_etape6','widget'=>array('datepicker')))
			->with(compact(array('date','currentDate','data')));
		}

		public function addDispo(){

			$input = Input::all();

			$rules = array(
				'date_debut'=>'date',
				'date_fin'=>'date|min:'.$input['date_debut'],
				);

			$validation = Validator::make($input, $rules);

			if( $validation ){

				$calendrier = new Calendrier;

				$calendrier->date_debut = Helpers::toServerDate($input['date_debut']);
				$calendrier->date_fin = Helpers::toServerDate($input['date_fin']);
				$calendrier->propriete_id = $input['proprieteId'];
				$calendrier->save();

				$propriete = Propriete::find( (int)$input['proprieteId'] );
				$propriete->etape = Propriete::getCurrentStep();
				$propriete->save();

				Session::put('etape6',true);

				if($calendrier){

					return Response::json( Calendrier::whereProprieteId($propriete->id)->get(), 200 );

				}

			}

			return Response::json('error', 400);
		}

	/**
	*
	* Get une ligne du calendrier
	*
	**/
	
	public function getOneDispo( $id ){

		if(isset($id) && Helpers::isOk( $id )){

			$calendrier = Calendrier::find($id);

			if($calendrier){

				return Response::json($calendrier, 200);

			}
		}

		return Response::json('error', 400);
	}

	public function updateDispo(){

		$input = Input::all();

		$date_debut = Helpers::createCarbonDate(Helpers::toServerDate($input['date_debut']));
		$date_fin = Helpers::createCarbonDate(Helpers::toServerDate($input['date_fin']));
		$diff = $date_debut->diffInDays( $date_fin, false );

		$rules = array(
			'date_debut'=>'date',
			'date_fin'=>'date',
			'tarif_id'=>'integer',
			);

		$validation = Validator::make($input, $rules);

		if( $validation->passes() && $diff > 0){

			$calendrier = Calendrier::find($input['tarif_id']);

			$calendrier->date_debut = Helpers::toServerDate($input['date_debut']);
			$calendrier->date_fin = Helpers::toServerDate($input['date_fin']);

			$calendrier->save();

			$propriete = $calendrier->propriete()->first();

			if($calendrier){

				return Response::json( Calendrier::whereProprieteId($propriete->id)->get(), 200 );

			} 
			
		}
		return Response::json('error', 400);

	}
	public function deleteDispo(){
		$input = Input::all();
		
		$rules = array(
			'tarif_id'=>'integer',
			);

		$validation = Validator::make($input, $rules);

		if( $validation ){

			$calendrier = Calendrier::find($input['tarif_id']);
			$propriete = $calendrier->propriete()->first();
			$calendrier->delete();


			if($calendrier){

				return Response::json( Calendrier::whereProprieteId($propriete->id)->get(), 200 );

			} 
			
		}
		return Response::json('error', 400);

	}
	/*-----  End of ETAPE 6  ------*/

	/*===============================
	=            ETAPE 7            =
	===============================*/

	public function indexCoordonne($data){
		
		$edit = false;

		if(is_object($data) || Session::has('proprieteId')){

			if(!is_object($data)){

				$edit = false;

				$data = Propriete::findOrFail(Session::get('proprieteId'));

			}else{

				$edit = true;
			}

			$paysId = $data->pays_id;

			$regionId = $data->region_id;

			$sousRegionId = $data->sous_region_id;

			$localiteId = $data->localite_id;

			

			/*$latlng = Propriete::find($data->id)->latlng;*/

		}	

		$user = $data->user()->first();

		$tel1 = $user->telephone()->whereOrdre(1)->get();
		$tel2 = $user->telephone()->whereOrdre(2)->get();

		$langue = User::getLangages( $user->id );
		
			/**
			*
			* Preparation des listes pour les selects
			*
			**/
			
			$paysList = Pays::getListForm();

			$regionList = Region::getListForm();

			$sousRegionList = SousRegion::getListForm();

			$localiteList = Localite::getListForm();
			

			/**
			*
			* On est toujours à l'étape 7
			*
			**/
			
			Session::put('currentEtape', 7 );

			if( $edit && !Session::has('proprieteId') ){

				return View::make('inscription.etape7', array('page'=>'inscription_etape7','widget'=>array('select')))

				->with(compact(array('user','paysList','regionList','sousRegionList','localiteList','data','paysId','regionId','sousRegionId','localiteId','langue','tel1','tel2')));

			}else{

				return View::make('inscription.etape7', array('page'=>'inscription_etape7','widget'=>array('select')))

				->with(compact(array('user','paysList','regionList','sousRegionList','localiteList','data','paysId','regionId','sousRegionId','localiteId','langue','tel1','tel2')));

			}
		}
		public function updateCoordonne( $data ){

			$input = Input::all();

			$edit = false;

			if(is_object($data) || Session::has('proprieteId')){

				if(!is_object($data)){

					$edit = false;

					$data = Propriete::findOrFail(Session::get('proprieteId'));

				}else{

					$edit = true;

					$propriete = $data;
				}
			}

			User::$coordonneRules['email'] = 'unique:users,email,'. Auth::user()->id .'| required | email';

			$validator = Validator::make($input, User::$coordonneRules);

			Session::put('input_7', $input);

			if($validator->passes()){

				$user = Auth::user();	

				$tel1 = UserTelephone::whereUserId($user->id)->whereOrdre('1')->first();
				$tel2 = UserTelephone::whereUserId($user->id)->whereOrdre('2')->first();
				
				$langages = $user->langage()->get();

				$user->prenom = $input['prenom'];
				$user->nom = $input['nom'];
				$user->email = $input['email'];
				$user->site_web = $input['site'];
				$user->personne_contact = $input['contact'];
				$user->pays_id = $input['pays'];
				$user->sous_region_id = $input['sous_region'];
				$user->localite_id = $input['localite'];
				$user->region_id = $input['region'];
				$user->adresse = $input['adresse'];
				$user->postal = $input['postal'];
				$user->fax = $input['fax'];
				$user->maternelle_id = 1;

				if(Helpers::isOk($tel1)){

					$tel1->numero = $input['tel1'];
					$tel1->heure = $input['heure1'];
					$tel1->ordre = 1;
					$user->telephone()->save($tel1);

				}else{

					$tel1 = new UserTelephone;
					$tel1->numero = $input['tel1'];
					$tel1->heure = $input['heure1'];
					$tel1->ordre = 1;
					$user->telephone()->save($tel1);
				}

				if(Helpers::isOk($tel2)){

					$tel2->numero = $input['tel2'];
					$tel2->heure = $input['heure2'];
					$tel2->ordre = 2;
					$user->telephone()->save($tel2);

				}else{

					$tel2 = new UserTelephone;
					$tel2->numero = $input['tel2'];
					$tel2->heure = $input['heure2'];
					$tel2->ordre = 2;
					$user->telephone()->save($tel2);
				}

				if($langages){

					$user->langage()->detach();

					foreach($input['autre'] as $key => $valeur){
						
						$user->langage()->attach($key);

					}

				}else{

					foreach($input['autre'] as $key => $valeur){

						$user->langage()->attach($key);

					}

				}

				$user->save();

				if($user){

					Session::put('etape7',true);

					if( $edit ){

						return Redirect::route( 'editPropriete7' , $propriete->id )
						->with(array('success', Lang::get('validation.custom.step7')));

					}else{

						return Redirect::route( 'etape7Index' , Auth::user()->slug )
						->with(array('success', Lang::get('validation.custom.step7')));

					}
				}

				
			}
			else{

				dd($validator->failed());
				if( $edit ){

					return Redirect::route( 'editPropriete6' , $data->id )
					->with(array('success',Lang::get('validation.custom.step2')));

				}else{

					return Redirect::route( 'etape6Index' , Auth::user()->slug )
					->with(array('success',Lang::get('validation.custom.step2')));

				}

			}




		}

		/*-----  End of ETAPE 7  ------*/



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