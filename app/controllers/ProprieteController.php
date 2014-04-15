<?php

class ProprieteController extends BaseController {

	public function show( $slug ){
		
		$propriete = Propriete::whereSlug( $slug )->first();

		return View::make('propriete.show', array('page'=>'showPropriete'))
		->with(compact(array('propriete')));
	}

	public function getPhoto( $proprieteId ){

		return Propriete::getPhoto( $proprieteId, null, 'json' );
	}

}