<?php


class SousRegion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	public function user(){

		return $this->hasMany('User');

	}

	public function sousRegionTraduction(){

		return $this->hasMany('SousRegionTraduction');

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

		$sousRegionDump = DB::table('sous_regions')
		->join('sous_regions_traductions','sous_regions.id','=','sous_region_id')
		->where(Config::get('var.lang_col'),Session::get('langId'))
		->orderBy( $orderBy , $orderWay )
		->get(array('nom','sous_region_id'));

	}
	else{

		$sousRegionDump = DB::table('sous_regions')
		->join('sous_regions_traductions','sous_regions.id','=','sous_region_id')
		->where($where.'_id', $whereId) 
		->where(Config::get('var.lang_col'),Session::get('langId'))
		->orderBy( $orderBy , $orderWay )
		->get();
	}

	/*dd(DB::getQueryLog());*/
	
	/**
	*
	* Retravaille l'output de manière à avoir id => nom
	*
	**/
	if(Helpers::isOk($json) && $json === true){

		$sousRegionList = array();

		foreach($sousRegionDump as $sousRegion){

			array_push($sousRegionList , array(
				'id'=>$sousRegion->sous_region_id,
				'val'=>$sousRegion->nom
				));
		}

	}
	else{

		$sousRegionList = array(
			''=>''
			);

		foreach($sousRegionDump as $sousRegion){

			$sousRegionList[$sousRegion->sous_region_id]  = $sousRegion->nom;

		}
	}

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/
	if(Helpers::isOk($json) && $json === true){
		
		return json_encode($sousRegionList);

	}else{

		return $sousRegionList;

	}
}
	/**
	*
	* Avoir la liste des pays sous forme d'array associative $key => value
	*
	**/
	public static function getChildListForm( $where = null, $where2 = null, $where3 = null, $whereId = null, $json = false, $orderBy = 'nom', $orderWay = 'asc' ){

	/**
	*
	* Select les pays AVEC les traductions OU l'id de lang est X, fetch un tableau (laravel collection)
	*
	**/
	if(Helpers::isOk($where)){

		if(Helpers::isNotOk($where2) && Helpers::isNotOk($where3) && Helpers::isOk($whereId)) {

			$sousRegionDump = DB::table('sous_regions')
			->join('sous_regions_traductions','sous_regions.id','=','sous_region_id')
			->where($where.'_id', $whereId) 
			->where(Config::get('var.lang_col'),Session::get('langId'))
			->orderBy( $orderBy , $orderWay )
			->get();

		}
		elseif(Helpers::isOk($where) && Helpers::isOk($where2) && Helpers::isNotOk($where3) && Helpers::isOk($whereId)) {

		/*	$sousRegionDump = DB::table('sous_regions')
			->join('regions','sous_regions.region_id','=','regions.id')
			->join('pays','regions.pays_id','=','pays.id')
			->join('regions_traductions','regions.id','=','regions_traductions.region_id')
			->join('sous_regions_traductions','sous_regions.id','=','sous_region_id')
			->where('regions.'.$where2.'_id', (int)$whereId) 
			->where('regions_traductions.'.Config::get('var.lang_col'), Session::get('langId'))
			->where('sous_regions_traductions.'.Config::get('var.lang_col'), Session::get('langId'))
			->orderBy('sous_regions_traductions.'.$orderBy , $orderWay )
			->get(array(
				'sous_regions_traductions.nom'));*/

$sousRegionDump = DB::table('pays')
->join('regions','pays.id','=','regions.pays_id')
->join('sous_regions','regions.id','=','sous_regions.region_id')
->join('sous_regions_traductions','sous_regions.id','=','sous_regions_traductions.sous_region_id')
->where('regions.'.$where2.'_id', (int)$whereId) 
->where('sous_regions_traductions.'.Config::get('var.lang_col'), Session::get('langId'))
->get(array(
	'sous_regions_traductions.nom',
	'sous_regions_traductions.sous_region_id'));
}
}
/*dd(DB::getQueryLog());*/



	/**
	*
	* Retravaille l'output de manière à avoir id => nom
	*
	**/
	if(Helpers::isOk($json) && $json === true){

		$sousRegionList = array();

		foreach($sousRegionDump as $sousRegion){

			array_push($sousRegionList , array(
				'id'=>$sousRegion->sous_region_id,
				'val'=>$sousRegion->nom
				));
		}

	}
	else{

		$sousRegionList = array(
			''=>''
			);

		foreach($sousRegionDump as $sousRegion){

			$sousRegionList[$sousRegion->sous_region_id]  = $sousRegion->nom;

		}
	}

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/
	if(Helpers::isOk($json) && $json === true){

		return json_encode($sousRegionList);

	}else{

		return $sousRegionList;

	}
}

}