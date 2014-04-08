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

		return View::make('inscription.index', array('page'=>'inscription_etape1','widget'=>array('select')))
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

				return View::make('inscription.etape2',array('page'=>'inscription_etape2','widget'=>array('select','tab')))
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
			return Redirect::route( 'etape1Index', Auth::user()->slug )
			->withInput()
			->withErrors($validation);

		}

	}
	public function updateBatiment( $Propriete_id ){

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
			dd('toto');
			$propriete = Propriete::find( $Propriete_id );

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

			$propriete->save();


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

			ProprieteTraduction::whereProprieteId($id)->whereKey('titre')->delete();
			
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
			ProprieteTraduction::whereProprieteId($id)->whereKey('description')->delete();

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
			$propriete->option()->detach();


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

			Session::put('etape2',true);
			Session::put('currentEtape', 2 );

			return Redirect::route( 'etape2Index' , Auth::user()->slug )
			->with(array('success',Lang::get('validation.custom.step2')));
		}else{

			Session::put('etape1',false);
			Session::put('currentEtape', 2 );
			return Redirect::route( 'etape1Index', Auth::user()->slug )
			->withInput()
			->withErrors($validation);
		}
	}
	/*-----  End of ETAPE 2  ------*/

		/*==============================
		=            ETAPE3            =
		==============================*/
		
		public function indexLocalisation(){

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

			return View::make('inscription.etape3', array('page'=>'inscription_etape3','widget'=>array('select')))

			->with(compact(array('paysList','regionList','sousRegionList','localiteList','situationList','situationId','distanceId')));

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
			
			Session::put('input_3', $input );

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

		public function updateLocalisation(){

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
			
			Session::put('input_3', $input );

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
		
		/*-----  End of ETAPE3  ------*/


		/*===============================
		=            ETAPE 4            =
		===============================*/
		public function indexPhoto(){

			$photosPropriete = Propriete::getPhoto( Session::get('proprieteId'), Config::get('var.image_thumbnail'));

			Session::put('currentEtape', 4 );

			return View::make('inscription.etape4', array('page'=>'inscription_etape4'))
			->with(compact('photosPropriete'));
		}
		
		public function savePhoto(){

			$input = Input::all();

			$rules = array('video'=>'url');

			$validation  = Validator::make($input, $rules);

			if( $validation ){

				$propriete = Propriete::find(Session::get('proprieteId'));
				$propriete->video = $input['video'];
				$propriete->save();

				Session::put('input_4', $input);
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
		
		/*-----  End of ETAPE 4  ------*/
		
		/*==============================
		=            ETAPE5            =
		==============================*/
		
		public function indexTarif(){

			$nuits = array(
				''=>''
				);

			for( $i = 1; $i < Config::get('var.nb_nuits'); $i++){
				$nuits[$i] = $i.' '.Lang::get('general.nuits');
			}

			$monnaies = Monnaie::getList(  );

			$jours = JourSemaine::getList();

			$tarifs = Tarif::with(array('monnaie','tarifSpeciauxWeekend'))->where('propriete_id',Session::get('proprieteId'))->orderBy('id','asc')->get();

			Session::put('currentEtape', 5 );

			return View::make('inscription.etape5', array('page'=>'inscription_etape5','widget'=>array('datepicker','select')))
			->with(compact('nuits','monnaies','jours','tarifs'));
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
			
			Session::put('input_4', $input );

			/**
			*
			* On est toujours à l'étape 5
			*
			**/
			
			Session::put('currentEtape', 5);


			$propriete = Propriete::find(Session::get('proprieteId'));

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
			$tarif->prix_weekend = $input['prix_weekend']; 
			if(isset($input['arrive']) && Helpers::isOk( $input['arrive'])){

				$tarif->jour_arrive_id = $input['arrive'];

			}
			$tarif->monnaie_id = $input['monnaie'];

			if(Helpers::isOk( $tarif->weekend )){

				$tarif->prix_weekend = $input['prix_weekend'];

			}

			
			$tarifSpeciaux = new TarifSpeciauxWeekend;

			if(isset($input['duree_supp']) && Helpers::isOK( $input['duree_supp'] )){

				$tarifSpeciaux->max_nuit = $input['nuit_max'];
				
			}
			$tarifSpeciaux->save();

			if(isset( $input['jour_weekend'] ) && Helpers::isOk( $input['jour_weekend'] )){

				foreach( $input['jour_weekend'] as $key => $jour ){

					$tarifSpeciaux->jourSemaine()->save( $tarifSpeciaux , array('jour_semaine_id'=>$key));


				}
			}

			$tarif = $propriete->tarif()->save($tarif);
			$tarif = $monnaie->tarif()->save($tarif);
			$tarif = $tarifSpeciaux->tarif()->save($tarif);
			$tarif->save();

			$propriete = Propriete::find(Session::get('proprieteId'));

			$propriete->etape = Helpers::isOk(Propriete::getCurrentStep()) ? Propriete::getCurrentStep() : 5;

			$propriete->save();

			if(Helpers::isOk($tarif)){

				return Response::json($tarif->with(array('monnaie','tarifSpeciauxWeekend'))->where('propriete_id',Session::get('proprieteId'))->orderBy('id','desc')->get(), 200);

			} else {

				return Response::json('error', 400);
			}

		}
		public function saveTarif(  ){

			$input = Input::all();

			/**
			*
			* On ajout les inputs à la session
			*
			**/
			
			Session::put('input_4bis', $input );

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

		/*-----  End of ETAPE5  ------*/


		/*===============================
		=            ETAPE 6            =
		===============================*/
		public function indexDisponibilite(){
			/**
			
				TODO:
				- Ajouter orientation dans saveBatiment
			
				**/
				//$calendrier = Calendrier::whereProprieteId( Session::get('proprieteId'))->get();

				$currentDate = Carbon::now(); 
				$date = date('n');
				return View::make('inscription.etape6', array('page'=>'inscription_etape6','widget'=>array('datepicker')))
				->with(compact(array('date','currentDate')));
			}

			public function addDispo(){

				$input = Input::all();
				$rules = array(
					'date_debut'=>'date',
					'date_fin'=>'date|min:'.$input['date_debut'],
					);

				$validation = Validator::make($input, $rules);

				if( $validation ){
					
					$propriete = Propriete::find( Session::get('proprieteId') );
					$statutCalendrier = StatutCalendrier::find(1);

					$calendrier = new Calendrier;

					$calendrier->date_debut = Helpers::toServerDate($input['date_debut']);
					$calendrier->date_fin = Helpers::toServerDate($input['date_fin']);
					$calendrier->propriete_id = Session::get('proprieteId');
					$calendrier->statut_calendrier_id = 1;
					$calendrier->save();

					Session::put('etape5',true);

					if($calendrier){

						return Response::json( Calendrier::whereProprieteId(Session::get('proprieteId'))->get(), 200 );

					} else {

						return Response::json('error', 400);
					}
				}

		/*		$calendrier->propriete()->save( $calendrier );
		$calendrier->statutCalendrier()->save( $calendrier );*/

		dd($calendrier);

		dd('pasok');

	}
	/*-----  End of ETAPE 6  ------*/



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