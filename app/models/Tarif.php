<?php


class Tarif extends Eloquent {

	/**
	 * The database table used by the model.
	 * @var string
	 */

	public function propriete(){

		return $this->belongsTo('Propriete');

	}

	public function jourSemaine(){

		return $this->belongsTo('JourSemaine');
	}

	public function monnaie(){

		return $this->belongsTo('Monnaie');
	}

	public function tarifSpeciauxWeekend(){

		return $this->belongsTo('TarifSpeciauxWeekend','tarif_special_weekend_id');
	}


	}