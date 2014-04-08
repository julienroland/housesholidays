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
		'build_from' => 'nom',
		'save_to'    => 'slug',
		);

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

	public function annoncePaye(){

		return $this->belongsTo('AnnoncePaye');

	}

	public function calendrier(){

		return $this->hasMany('Calendrier');

	}

	public static function getCurrentStep(){

		return Session::has('currentEtape') ? Session::get('currentEtape') : 1;

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

        $proprietes = Propriete::find( $proprieteId )->photoPropriete()->orderBy('created_at','desc')->get();

        $extension = ImageType::where('nom',Config::get('var.image_thumbnail'))->pluck('extension');

        $data = array(
        	'data'=>array());

        foreach( $proprietes as $propriete){

        	array_push($data['data'], (object)array( 

        		'url'=>Helpers::addBeforeExtension($propriete->url, $type),
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
}