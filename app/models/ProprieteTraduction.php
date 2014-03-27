<?php


class ProprieteTraduction extends Eloquent {


	protected $table = 'proprietes_traductions';

	public function propriete(){

		return $this->belongsTo('Propriete');

	}

	public function langage(){

		return $this->belongsTo('Langage');

	}
}