<?php


class Commentaire extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	public function user(){

		return $this->belongsTo('User');
	}

	public function propriete(){

		return $this->belongsTo('Propriete');

	}

}