<?php


class OptionTraduction extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'options_traductions';

	public function option(){

		return $this->belongsTo('Option');

	}

	public function langage(){

		return $this->belongsTo('Langage');

	}
}