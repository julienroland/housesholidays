<?php


class Localite extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	public function user(){

		return $this->hasMany('User');

	}
	public function propriete(){

		return $this->hasMany('Propriete');

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
	$localiteDump = Localite::all();

	/**
	*
	* Retravaille l'output de manière à avoir id => nom
	*
	**/
	$localiteList = array(
		''=>''
		);

	foreach($localiteDump as $localite){

		$localiteList[$localite->id] = $localite->nom;

	}

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return $localiteList;
	}

}