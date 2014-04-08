<?php


class Calendrier extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	public function propriete(){

		return $this->belongsTo('Propriete');
	}

	public function statutCalendrier(){

		return $this->belongsTo('StatutCalendrier');

	}
}