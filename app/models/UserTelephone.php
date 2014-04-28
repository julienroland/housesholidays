<?php


class UserTelephone extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_telephones';

	public function user(){

		return $this->belongsTo('User');

	}

}