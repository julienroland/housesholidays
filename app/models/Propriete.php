<?php

use Carbon\Carbon;
class Propriete extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	public static $rules1 =  array(

		'titre_propriete'=> 'required',
		'nom_propriete'=> 'required',
		'type_propriete'=> 'required|integer',
		'nb_personne'=> 'required|integer',
		'nb_chambre'=> 'required|integer',
		'etage'=> 'required',
		'taille_interieur'=> 'required|numeric',
		'nb_sdb'=> 'integer',
		'dimension_exterieur'=> 'numeric',
		'literie'=> 'numeric',

		);
	public static $rules2 = array(
		'pays'=> 'required|integer',
		'region'=> 'required|integer',
		'sous_region'=>'required|integer',
		'localite'=>'required|integer',
		'adresse'=>'required',
		'distance'=>'required|integer',
		);

	public static $sluggable = array(
		'build_from' => 'fullname',
		'save_to'    => 'slug',
		);

	public function getFullnameAttribute() {

		if(Session::has('proprieteId')){

			$propriete = Propriete::getLocations( Session::get('proprieteId') );

			if(isset($propriete->proprieteTraduction[0]->cle) && $propriete->proprieteTraduction[0]->cle ==='titre'){

				$titre = $propriete->proprieteTraduction[0]->valeur;

			}else{

				$titre = '';
			}

			if(isset( $propriete->typeBatiment->typeBatimentTraduction[0]->nom ) && isset( $propriete->localite->nom ) && isset( $titre )){

				return $propriete->typeBatiment->typeBatimentTraduction[0]->nom . ' ' .$propriete->localite->nom . ' ' . $titre;

			}

		}

	}

	public function proprieteTraduction(){

		return $this->hasMany('ProprieteTraduction')
		->where(Config::get('var.lang_col'),Session::get('langId'));

	}

	public function tarif(){

		return $this->hasMany('Tarif');

	}

	public function photoPropriete(){

		return $this->hasMany('PhotoPropriete');

	}

	public function option(){

		return $this->belongsToMany('Option')
		->withPivot('valeur')
		->withTimestamps();

	}
	public function user(){

		return $this->belongsTo('User');

	}

	public function typeBatiment(){

		return $this->belongsTo('TypeBatiment');

	}

	public function pays(){

		return $this->belongsTo('Pays');

	}

	public function region(){

		return $this->belongsTo('Region');

	}

	public function sousRegion(){

		return $this->belongsTo('SousRegion');

	}

	public function localite(){

		return $this->belongsTo('Localite');

	}

	public function annoncePaye(){

		return $this->belongsTo('AnnoncePaye');

	}

	public function calendrier(){

		return $this->hasMany('Calendrier');

	}

	public function message(){

		return $this->hasMany('Message');

	}

	public function favoris(){

		return $this->hasMany('Favoris');

	}
	public function commentaire(){

		return $this->hasMany('Commentaire');
		
	}

	public static function getCurrentStep(){

		return Session::has('currentEtape') ? Session::get('currentEtape') : 1;

	}

	public static function getLocations( $proprieteId = null){

		if(Helpers::isNotOk( $proprieteId)){

			$proprieteDump = User::find( Auth::user()->id )
			->propriete(  )
			->with(array(
				'proprieteTraduction',
				'localite',
				'sousRegion.sousRegionTraduction',
				'region.regionTraduction',
				'pays.paysTraduction',
				'tarif',
				'typeBatiment.typeBatimentTraduction',
				'photoPropriete'=>function($query){
					$query->whereOrdre('1');
				},
				))
			->where( 'etape','!=','' )
			->orderBy('created_at','desc')
			->remember(60 * 24, 'proprietes')
			->get(  );

		}else{

			$proprieteDump = Propriete::
			with(array(
				'proprieteTraduction',
				'localite',
				'sousRegion.sousRegionTraduction',
				'region.regionTraduction',
				'pays.paysTraduction',
				'typeBatiment.typeBatimentTraduction',
				'photoPropriete',
				))
			->where( 'etape','!=','' )
			->where('user_id', Auth::user()->id )
			->whereId($proprieteId)
			->remember(60 * 24, 'proprietes')
			->first(  );

		}



		return $proprieteDump;
	}

	public static function getMinTarif( $propriete, $col = null){

		if(Helpers::isNotOk($col)){

			$col = Config::get('var.semaine_col');
		}


		$getMinDump = $propriete->tarif()->min($col);

		return $getMinDump;

	}

	public static function getMaxTarif( $propriete, $col = null){

		if(Helpers::isNotOk($col)){

			$col = Config::get('var.semaine_col');
		}


		$getMaxDump = $propriete->tarif()->max($col);

		return $getMaxDump;

	}
	public static function getPhoto( $proprieteId , $type = null, $output = null ) {

		if(!isset($type) && Helpers::isNotOk( $type ))
		{
			$type = Config::get('var.image_thumbnail');
		}
		
        /**
        *
        * Get propriete par son id et le user
        *
        **/

        $proprietes = Propriete::find( $proprieteId )->photoPropriete()->orderBy('ordre','asc')->get();

        $extension = ImageType::where('nom',Config::get('var.image_thumbnail'))->pluck('extension');

        $data = array(
        	'data'=>array());

        foreach( $proprietes as $propriete){

        	array_push($data['data'], (object)array( 

        		'url'=>Helpers::addBeforeExtension($propriete->url, $type),
        		'ordre'=>$propriete->ordre,
        		'date'=>$propriete->created_at->toDateTimeString(),
        		'propriete_id'=>$propriete->propriete_id,
        		'alt'=>$propriete->alt,
        		'extension'=>$extension,
        		'id'=>$propriete->id,
        		) );


        }

        $data['count'] = count( $proprietes );
        
        if( $output==='json' ){

        	return json_encode((object)$data);
        	
        }
        else
        {
        	return (object)$data;
        }
    }

    public static function getOption($proprieteId = null,  $orderBy='valeur', $orderWay='asc'){

		/**
		*
		* Select les option AVEC les traductions en fonction du type d'option, fetch un tableau (laravel collection)
		*
		**/


		$data = array(
			'data'=>array(),
			/*'exterieur'=> array(
				),
			'interieur'=> array(
				),
			'literie'=> array(
				),*/
		);

		$d = array('b_literie','b_interieur','b_exterieur');


		foreach($d as $typeOption){

			$optionDump = Propriete::whereId( $proprieteId )->with(array('option'))->first();

			/*->whereNom('b_interieur')->whereNom('b_exterieur')*/

			$t= array();

			foreach($optionDump->option as $options){

				$data['data'][$options->id] = $options->pivot->valeur;

			}

			/*foreach($t[$typeOption] as $dataArr){

				
				$data[str_replace('b_','',$typeOption)][$dataArr->pivot->option_id] = (object)array('id'=>$dataArr->pivot->option_id,'valeur' =>$dataArr->pivot->valeur);
			}*/
			
		}

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return (object)$data;
}
public static function getOptions($proprieteId = null,  $orderBy='valeur', $orderWay='asc'){

	$optionsDump = 
	Propriete::with(array('option.optionTraduction'))
	->whereId($proprieteId)->first();

	$data = array(
		'data'=>array(
			),
		'count'=>'',
		);
	
	foreach($optionsDump->option as $option){

		if($option !=='situation'){

			$data['data'][$option->optionTraduction[0]->cle] = array('nom'=>$option->optionTraduction[0]->valeur,'id'=> $option->id, 'valeur'=>$option->pivot->valeur);

		}
	}

	$data['count'] = count($optionsDump->option);
	$data['data'] = (object)$data['data'];

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return (object)$data;
}
public static function getSituations($proprieteId = null,  $orderBy='valeur', $orderWay='asc'){

	$situationDump = 
	Propriete::with(array('option'=>function($query){
		$query->where('options.id', 44 );
	}))
	->whereId($proprieteId)->remember(60 * 24)->first();

	$d = array();

	foreach($situationDump->option as $situation){
		array_push($d, $situation->pivot->valeur);
	}

	$traductionDump = OptionTraduction::find( $d );

	$data = array(
		'data'=>array(),
		'count'=>'',
		);

	foreach($traductionDump as $situation){

		array_push($data['data'] , (object)array('id'=>$situation->id, 'nom'=>$situation->valeur,'valeur'=>''));
	}
	
	$data['count'] = count($traductionDump);

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return (object)$data;
}

public static function getLiterie($proprieteId = null,  $orderBy='valeur', $orderWay='asc'){
	$literieDump = 
	Propriete::with(array('option'=>function($query){
		$query->where( 'type_option_id', Config::get('var.literie_col') );
	},'option.optionTraduction'))
	->whereId($proprieteId)->remember(60 * 24)->first();
	
	$data = array(
		'data'=>array(),
		'count'=>'',
		);

	foreach($literieDump->option as $literie){

		array_push($data['data'] , (object)array('id'=>$literie->optionTraduction[0]->id, 'nom'=>$literie->optionTraduction[0]->valeur,'valeur'=>$literie->pivot->valeur));
	}
	
	$data['count'] = count($literieDump->option);

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return (object)$data;
}

public static function getExterieur($proprieteId = null,  $orderBy='valeur', $orderWay='asc'){
	$exterieurDump = 
	Propriete::with(array('option'=>function($query){
		$query->where( 'type_option_id', Config::get('var.exterieur_col') );
	},'option.optionTraduction'))
	->whereId($proprieteId)->remember(60 * 24)->first();
	
	$data = array(
		'data'=>array(),
		'count'=>'',
		);

	foreach($exterieurDump->option as $exterieur){

		array_push($data['data'], (object)array('id'=>$exterieur->optionTraduction[0]->id, 'nom'=>$exterieur->optionTraduction[0]->valeur,'valeur'=>$exterieur->pivot->valeur));
	}
	
	$data['count'] = count($exterieurDump->option);
	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return (object)$data;
}

public static function getInterieur($proprieteId = null,  $orderBy='valeur', $orderWay='asc'){
	$interieurDump = 
	Propriete::with(array('option'=>function($query){
		$query->where( 'type_option_id', Config::get('var.interieur_col') );
	},'option.optionTraduction'))
	->whereId($proprieteId)->remember(60 * 24)->first();
	
	$data = array(
		'data'=>array(),
		'count'=>'',
		);

	foreach($interieurDump->option as $interieur){

		array_push($data['data'] , (object)array('id'=>$interieur->optionTraduction[0]->id, 'nom'=>$interieur->optionTraduction[0]->valeur,'valeur'=>$interieur->pivot->valeur));
	}
	
	$data['count'] = count($interieurDump->option);

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return (object)$data;
}
}