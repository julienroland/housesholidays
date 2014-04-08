<?php


class Langage extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	public function paysTraduction(){

		return $this->hasMany('PaysTraduction')
		->where(Config::get('var.lang_col'),Session::get('langId'));

	}

}