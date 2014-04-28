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

	public function user(){

		return $this->belongsToMany('User','users_langages_traductions');
		
	}

}