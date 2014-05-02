<?php


class Message extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	public function sender(){

		return $this->belongsTo('User','de_user_id');
	}

	public function receiver(){

		return $this->belongsTo('User','vers_user_id');
	}

	public function reponse(){

		return $this->belongsTo('Message','reponse_id')
		->whereNotNull('reponse_id');
	}

	public function propriete(){

		return $this->belongsTo('Propriete');

	}
}