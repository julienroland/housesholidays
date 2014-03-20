<?php


class Pays extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pays';

	public function user(){

		return $this->hasMany('User');

	}

	public function paysTraduction(){

		return $this->hasMany('PaysTraduction');

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
	$paysDump = Pays::with(array('paysTraduction'=>function($query) use( $orderBy, $orderWay ){

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
	$paysList = array();

	foreach($paysDump as $pays){

		$paysList[$pays->id] = $pays->paysTraduction[0]->nom;

	}

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return $paysList;
	}

}