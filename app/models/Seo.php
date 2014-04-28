<?php


class Seo extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	
	protected $table="seo";

	public function seoTraduction(){

		return $this->hasMany('SeoTraduction');
	}

	public function seo(){

		return $this->morphTo();
	}

}