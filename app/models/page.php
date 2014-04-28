<?php


class Page extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected static $rules = array(
		);

	public function pageTraduction(){

		return $this->hasMany('PageTraduction');
	}

	public function seo(){

		return $this->morphMany('Seo','content');
	}

}