<?php


class PaiementStatut extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'paiements_statuts';

	public function annoncePaye(){

		return $this->hasMany('AnnoncePaye');

	}

}