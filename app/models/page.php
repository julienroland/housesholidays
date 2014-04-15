<?php


class Page extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	public function pageTraduction(){

		return $this->hasMany('pageTraduction');
	}

	public function seo(){

		return $this->morphMany('Seo','content');
	}

}