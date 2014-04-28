<?php


class PageTraduction extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages_traductions';

	public static $sluggable = array(
		'build_from' => 'titre',
		'save_to'    => 'slug',
		);


	public function page(){

		return $this->belongsTo('Page');
	}

	public function langage(){

		return $this->belongsTo('Langage');
	}

}