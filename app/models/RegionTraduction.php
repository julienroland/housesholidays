<?php


class RegionTraduction extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'regions_traductions';

	public function region(){

		return $this->belongsTo('Region');

	}
}