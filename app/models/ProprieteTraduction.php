<?php


class ProprieteTraduction extends Eloquent {


	protected $table = 'proprietes_traductions';

	public function propriete(){

		return $this->belongsTo('Propriete');

	}

	public function langage(){

		return $this->belongsTo('Langage');

	}

	public static function getTitle( $proprieteId  ){

		$traductionDump = ProprieteTraduction::whereProprieteId( $proprieteId )->whereCle('titre')->get();

		$data = array(
			'data'=>array(),
			'count'=>$traductionDump->count()
		);
		foreach($traductionDump as $traduction){

			(object)$data['data'][$traduction->langage_id] = $traduction->valeur;
		}

		return (object)$data;
	}

	public static function getDescription( $proprieteId  ){

		$traductionDump = ProprieteTraduction::whereProprieteId( $proprieteId )->whereCle('description')->get();

		$data = array(
			'data'=>array(),
			'count'=>$traductionDump->count()
		);
		foreach($traductionDump as $traduction){

			(object)$data['data'][$traduction->langage_id] = $traduction->valeur;
		}

		return (object)$data;
	}
}