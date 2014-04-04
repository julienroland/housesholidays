<?php


class jourSemaineTraduction extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'jours_semaines_traductions';

	public function langage(){

		return $this->belongsTo('Langage');

	}

	public function jourSemaine(){

		return $this->belongsTo('jourSemaine');

	}

}