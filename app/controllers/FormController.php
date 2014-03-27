<?php

class FormController extends BaseController {

	public function getDataSelect( $from_table, $relation, $id ){

		/**
		*
		* Select le bon modele
		*
		**/
		$modele = ucFirst($from_table);

		/**
		*
		* Appel la function avec les filtres: where $relation.'_id', $id and json_encode
		*
		**/
		return $modele::getListForm( $relation, $id , true );
		
	}
	public function getChildDataSelect( $from_table, $relation_child1, $relation_child2 = null, $relation_child3 = null, $id ){

		if($relation_child1 == "null"){
			
			$relation_child1 = null;
		}
		if($relation_child2 == "null"){
			
			$relation_child2 = null;
		}
		if($relation_child3 == "null"){

			$relation_child3 = null;
		}
		/**
		*
		* Select le bon modele
		*
		**/

		$modele = ucFirst($from_table);

		/**
		*
		* Appel la function avec les filtres: where $relation.'_id', $id and json_encode
		*
		**/

		if(Helpers::isOk($relation_child1) && Helpers::isNotOk($relation_child1)){

			return $modele::getListForm( $relation_child1, null, null, $id , true );

		}
		elseif(Helpers::isOk($relation_child1) && Helpers::isOk($relation_child2) && Helpers::isNotOk($relation_child3)){

			return $modele::getChildListForm( $relation_child1, $relation_child2, null, $id , true );

		}
		elseif(Helpers::isOk($relation_child1) && Helpers::isOk($relation_child2) && Helpers::isOk($relation_child3)){

			return $modele::getChildListForm( $relation_child1, $relation_child2, $relation_child3, $id , true );

		}
		
	}

}