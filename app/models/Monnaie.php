<?php


class Monnaie extends Eloquent {

	/**
	 * The database table used by the model.
	 * @var string
	 */

	public function tarif(){

		return $this->hasMany('Tarif');

	}

	public static function getList( ){

		$monnaies = Monnaie::all();

		$listMonnaie = array();
		foreach( $monnaies as $monnaie ){

		$listMonnaie[$monnaie->id] = $monnaie->nom ;
		
		}
		return $listMonnaie;
	}

}