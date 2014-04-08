<?php


class StatutCalendrier extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'statuts_calendriers';
	
	public function propriete(){

		return $this->hasMany('Calendrier');
	}

	public function statutCalendrierTraduction(){

		return $this->hasMany('StatutCalendrierTraduction');
	}
}