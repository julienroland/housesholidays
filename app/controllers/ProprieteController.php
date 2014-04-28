<?php

class ProprieteController extends BaseController {

	public function show( $id ){

		$propriete = Propriete::getLocations( $id );

		$user = Propriete::find($id)->user()->first();

		$minPrice = Propriete::getMinTarif( $id, Config::get('var.semaine_col'));

		$maxPrice = Propriete::getMaxTarif( $id, Config::get('var.semaine_col'));

		$imageAccrocheType = imageType::whereNom(Config::get('var.image_standard'))->first();

		$imageSliderType = imageType::whereNom(Config::get('var.image_thumbnail'))->first();

		/*$options = Propriete::getOptions( $id );*/

		$situations = Propriete::getSituations( $id );

		$literies = Propriete::getLiterie( $id );

		$exterieurs = Propriete::getExterieur( $id );

		$interieurs = Propriete::getInterieur( $id );

		return View::make('propriete.show', array('page'=>'showPropriete','widget'=>array('carousel','tabs')))
		->with(compact(array('propriete','imageType','imageAccrocheType','imageSliderType','minPrice','maxPrice','user','options','situations','literies','exterieurs','interieurs')));
	}

	public function getPhoto( $proprieteId ){

		return Propriete::getPhoto( $proprieteId, null, 'json' );
	}

	public function refresh ($data){

		if($data->annonce_payee_id == 3){

			$touch = $data->touch();

			if($touch){

				return Response::json(trans('general.refreshDone'), 200);
			}

		}elseif($data->annonce_payee_id == 2){

			return Response::json(trans('general.en_attente'), 200);

		}elseif($data->annonce_payee_id == 1){

			return Response::json(trans('general.pas_payee'), 200);
		}

		
	}
}