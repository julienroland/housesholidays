<?php


class TarifSpeciauxWeekend extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = "tarifs_speciaux_weekends";

	public function tarif(){

		return $this->hasMany('Tarif','tarif_special_weekend_id');
	}

	public function jourSemaine(){

		return $this->belongsToMany('JourSemaine','jour_semaine_tarif_speciaux_weekend','tarif_id','jour_semaine_id');
	}
}