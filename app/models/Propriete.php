<?php


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
		'situation'=>'required|integer',
		'distance'=>'required|integer',
		'region_touristique'=>'required',
		);

	public static $sluggable = array(
		'build_from' => 'nom',
		'save_to'    => 'slug',
		);

	public function proprieteTraduction(){

		return $this->hasMany('proprieteTraduction');

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

	public static function getCurrentStep(){

		return Session::has('currentEtape') ? Session::get('currentEtape') : 1;

	}
}