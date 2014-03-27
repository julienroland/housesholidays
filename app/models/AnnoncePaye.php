<?php


class AnnoncePaye extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'annonces_payees';

	public function propriete(){

		return $this->hasMany('Propriete');

	}

	public function paiementStatut(){

		return $this->belongsTo('PaiementStatut');

	}
}