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

		return $this->hasMany('RegionTraduction')
		->where(Config::get('var.lang_col'),Session::get('langId'));

	}

	public function pays(){

		return $this->belongsTo('Pays');

	}

	/**
	*
	* Avoir la liste des pays sous forme d'array associative $key => value
	*
	**/
	public static function getListForm( $where = null, $whereId = null, $json = false, $orderBy = 'nom', $orderWay = 'asc' ){

	/**
	*
	* Select les pays AVEC les traductions OU l'id de lang est X, fetch un tableau (laravel collection)
	*
	**/
	if(Helpers::isNotOk($where) && Helpers::isNotOk($whereId)) {

		$regionDump = DB::table('regions')
		->join('regions_traductions','regions.id','=','region_id')
		->where(Config::get('var.lang_col'),Session::get('langId'))
		->orderBy( $orderBy , $orderWay )
		->get(array('nom','region_id'));

	}
	else{

		$regionDump = DB::table('regions')
		->join('regions_traductions','regions.id','=','region_id')
		->where($where.'_id', $whereId) 
		->where(Config::get('var.lang_col'),Session::get('langId'))
		->orderBy( $orderBy , $orderWay )
		->get(array('nom','region_id'));
	}
	/*dd(DB::getQueryLog());*/
	
	/**
	*
	* Retravaille l'output de manière à avoir id => nom
	*
	**/
	if(Helpers::isOk($json) && $json === true){

		$regionList = array();

		foreach($regionDump as $region){

			array_push($regionList , array(
				'id'=>$region->region_id,
				'val'=>$region->nom
				));
		}

	}
	else{

		$regionList = array(
			''=>''
			);

		foreach($regionDump as $region){

			$regionList[$region->region_id]  = $region->nom;

		}
	}

	

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/
	if(Helpers::isOk($json) && $json === true){

		return json_encode($regionList);

	}else{

		return $regionList;

	}
}

}