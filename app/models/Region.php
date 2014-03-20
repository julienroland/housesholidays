<?php


class Region extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	public function user(){

		return $this->hasMany('User');

	}

	public function regionTraduction(){

		return $this->hasMany('RegionTraduction');

	}

	/**
	*
	* Avoir la liste des pays sous forme d'array associative $key => value
	*
	**/
	public static function getListForm( $orderBy = 'nom', $orderWay = 'asc' )
	{

	/**
	*
	* Select les pays AVEC les traductions OU l'id de lang est X, fetch un tableau (laravel collection)
	*
	**/
	$regionDump = Region::with(array('regionTraduction'=>function($query) use( $orderBy, $orderWay ){

		$query
		->where(Config::get('var.lang_col'),Session::get('langId'))
		->orderBy( $orderBy , $orderWay );

	}
	))->get();

	/**
	*
	* Retravaille l'output de manière à avoir id => nom
	*
	**/
	$regionList = array();

	foreach($regionDump as $region){

		$regionList[$region->id] = $region->regionTraduction[0]->nom;

	}

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return $regionList;
	}

}