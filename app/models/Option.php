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

		return $this->hasMany('OptionTraduction')
		->where(Config::get('var.lang_col'),Session::get('langId'));

	}

	/**
	*
	* Avoir la liste des pays sous forme d'array associative $key => value
	*
	**/

	public static function getListForm( $etape = 'etape_2', $orderBy = 'valeur', $orderWay = 'asc' )
	{

		/**
		*
		* Select les option AVEC les traductions en fonction du type d'option, fetch un tableau (laravel collection)
		*
		**/
		$optionDump = TypeOption::with(array('enfant.option.optionTraduction'=>function( $query ) use( $orderBy, $orderWay ){

			$query->where(Config::get('var.lang_col'),Session::get('langId'))
			->orderBy( $orderBy , $orderWay );

		}))->whereNom($etape)->get();

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
		if($etape === 'etape_2'){

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

		}elseif($etape === 'etape_3'){

			$data = array(

				'situation'=> array(
					'' => '',
					),
				'situationId'=>array(
					'id'=>$t['b_situation_geographique'][0][0]->option_id
					),
				'distanceId'=>array(
					'id'=>$t['b_situation_geographique'][1][0]->option_id
					),
				);

			foreach($t['b_situation_geographique'][0] as $dataArr){

				$data['situation'][$dataArr->id] = $dataArr->valeur ;
			}

		}
	/**
	*
	* Return une array pour les selects dans les formulaires
	*
	**/

	return (object)$data;
}


}