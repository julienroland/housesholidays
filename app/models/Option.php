<?php


class Option extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	public function propriete(){

		return $this->belongsToMany('Propriete')
		->withPivot('valeur')
		->withTimestamps();

	}

	public function typeOption(){

		return $this->belongsTo('TypeOption');

	}

/*	public function typeOptionParent(){

		return $this->belongsTo('TypeOption');

	}*/

	public function optionTraduction(){

		return $this->hasMany('OptionTraduction');

	}

	/**
	*
	* Avoir la liste des pays sous forme d'array associative $key => value
	*
	**/

	public static function getListForm( $orderBy = 'id', $orderWay = 'asc' )
	{

	/**
	*
	* Select les option AVEC les traductions en fonction du type d'option, fetch un tableau (laravel collection)
	*
	**/
	$optionDump = TypeOption::with(array('enfant.option.optionTraduction'=>function($query){

		$query->where(Config::get('var.lang_col'),Session::get('langId'));

	}))->whereNom('etape_2')->get();

	$t= array();

	foreach($optionDump as $options){
		
		foreach($options->enfant as $enfant){
			$t[$enfant->nom] = array();
			if(Helpers::isOk($enfant->option)){
				foreach($enfant->option as $option){
					array_push($t[$enfant->nom], $option->optionTraduction);
				}
			}

		}
	}

	$data = array(
			'exterieur'=> array(
				),
			'interieur'=> array(
				),
		);

	foreach($t['b_exterieur'] as $dataArr){
		

		$data['exterieur'][$dataArr[0]->cle] = (object)array('id'=>$dataArr[0]->option_id,'valeur' =>$dataArr[0]->valeur);
	}

	foreach($t['b_interieur'] as $dataArr){

		$data['interieur'][$dataArr[0]->cle] = (object)array('id'=>$dataArr[0]->option_id,'valeur' => $dataArr[0]->valeur);
	}

	foreach($t['b_literie'] as $dataArr){

		$data['literie'][$dataArr[0]->cle] = (object)array('id'=>$dataArr[0]->option_id,'valeur' => $dataArr[0]->valeur);
	}

	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return (object)$data;
}


}