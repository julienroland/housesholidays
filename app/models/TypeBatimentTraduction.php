<?php


class TypeBatimentTraduction extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'types_batiments_traductions';

	public function typeBatiment(){

		return $this->belongsTo('TypeBatiment');

	}
}