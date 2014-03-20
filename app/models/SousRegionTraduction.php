<?php


class SousRegionTraduction extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sous_regions_traductions';

	public function sousRegion(){

		return $this->belongsTo('SousRegion');

	}
}