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
		'nom_propriete'=> 'required|alpha',
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

		$propriete = Propriete::getLocations(Session::get('proprieteId'));
		
		return $propriete->nom . ' ' . $propriete->pays->paysTraduction[0]->nom . '  ' . $propriete->region->regionTraduction[0]->nom . ' ' . $propriete->sousRegion->sousRegionTraduction[0]->nom . ' ' .$propriete->localite->nom;

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
					$query->whereAccroche('1');
				},
				))
			->where( 'etape','!=','' )
			->get(  );

		}else{

			$proprieteDump = Propriete::
			with(array(
				'proprieteTraduction',
				'localite',
				'sousRegion.sousRegionTraduction',
				'region.regionTraduction',
				'pays.paysTraduction',
				'tarif',
				'typeBatiment.typeBatimentTraduction',
				'photoPropriete'=>function($query){
					$query->whereAccroche('1');
				},
				))
			->where( 'etape','!=','' )
			->whereId($proprieteId)
			->first(  );

		}

		return $proprieteDump;
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
			'exterieur'=> array(
				),
			'interieur'=> array(
				),
			'literie'=> array(
				),
			);

		$d = array('b_literie','b_interieur','b_exterieur');


		foreach($d as $typeOption){

			$optionDump = Propriete::find( $proprieteId )->with(array('option.typeOption'=>function($query) use($typeOption){

				$query->whereNom($typeOption);

			}))->get();
			/*->whereNom('b_interieur')->whereNom('b_exterieur')*/

			$t= array();

			foreach($optionDump as $options){

				$t[$typeOption] = $options->option;

			}

			foreach($t[$typeOption] as $dataArr){

				
				$data[str_replace('b_','',$typeOption)][$dataArr->pivot->option_id] = (object)array('id'=>$dataArr->pivot->option_id,'valeur' =>$dataArr->pivot->valeur);
			}


			
		}
		dd($data);	
	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return (object)$data;
}
}