<?php


class PhotoPropriete extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'photos_proprietes';

	public function propriete(){

		return $this->belongsTo('Propriete');

	}
	public function imageType(){

		return $this->belongsTo('ImageType');

	}

}