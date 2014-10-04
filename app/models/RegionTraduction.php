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

    public function scopeLang($query)
    {
        $query->where(Config::get('var.lang_col'), Session::get('langId'));
    }
	
	public function langage(){

		return $this->belongsTo('Langage');

	}
}