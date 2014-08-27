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

		return $this->hasMany('PaysTraduction')
		->where(Config::get('var.lang_col'),Session::get('langId'));

	}

	public function region(){

		return $this->hasMany('Region');

	}

	public static function listById( $pays_id ){

		$paysDump = Pays::whereId( $pays_id )->with(array('region'=>function($query){
			$query->whereNotNull('coords');
		
		},'region.regionTraduction'))->first();

		$data = array();

		foreach($paysDump->region as $regions){
	
			$data[$regions->id] = (object)array(
				'nom'=> $regions->regionTraduction[0]->nom,
				'coords'=> $regions->coords,
				'description'=>$regions->regionTraduction[0]->description
				);

		}

		return $data;

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
	$paysDump = PaysTraduction::
		  where(Config::get('var.lang_col'),Session::get('langId'))
		->orderBy( $orderBy , $orderWay )
		->get();

	/**
	*
	* Retravaille l'output de manière à avoir id => nom
	*
	**/
	$paysList = array(
		''=>''
		);

	foreach($paysDump as $pays){

		$paysList[$pays->pays_id] = $pays->nom;

	}

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return $paysList;
	}
	/**
	*
	* Avoir la liste d'enfants des pays sous forme d'array associative $key => value
	*
	**/

	public static function getChildListForm( $orderBy = 'nom', $orderWay = 'asc' )
	{

	/**
	*
	* Select les pays AVEC les traductions OU l'id de lang est X, fetch un tableau (laravel collection)
	*
	**/
	$paysDump = PaysTraduction::
		  where(Config::get('var.lang_col'),Session::get('langId'))
		->orderBy( $orderBy , $orderWay )
		->get();

	/**
	*
	* Retravaille l'output de manière à avoir id => nom
	*
	**/
	$paysList = array(
		''=>''
		);

	foreach($paysDump as $pays){

		$paysList[$pays->pays_id] = $pays->nom;

	}

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return $paysList;
	}

}