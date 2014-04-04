<?php


class ImageType extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = "images_types";

	public function photoPropriete(){

		return $this->hasMany('PhotoPropriete');
	}
}