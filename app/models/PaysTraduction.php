<?php


class PaysTraduction extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pays_traductions';

	public function pays(){

		return $this->belongsTo('Pays');

	}
}