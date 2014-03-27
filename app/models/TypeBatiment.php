<?php


class TypeBatiment extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'types_batiments';

	/*public function propriete(){

		return $this->hasMany('Propriete');

	}*/

	public function typeBatimentTraduction(){

		return $this->hasMany('TypeBatimentTraduction');

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
	$typeBatimentDump = TypeBatiment::with(array('typeBatimentTraduction'=>function($query) use( $orderBy, $orderWay ){

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
	$typeBatimentList = array(
		''=>trans('form.choissir_option'));

	foreach($typeBatimentDump as $typeBatiment){

		$typeBatimentList[$typeBatiment->id] = $typeBatiment->typeBatimentTraduction[0]->nom;

	}

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return $typeBatimentList;
	}

}