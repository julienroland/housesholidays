<?php


class PaysTraduction extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pays_traductions';

	public function pays(){

		return $this->belongsTo('Pays');

	}
    public function scopeLang($query)
    {
        $query->where(Config::get('var.lang_col'), Session::get('langId'));
    }
	public function langage(){

		return $this->belongsTo('Langage');

	}
}