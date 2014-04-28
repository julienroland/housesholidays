<?php


class SeoTraduction extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	
	protected $table="seo_traductions";

	public function seo(){

		return $this->belongsTo('Seo');
	}

	public function langage(){

		return $this->belongsTo('Langage');
	}


}