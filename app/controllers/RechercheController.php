<?php

class RechercheController extends BaseController {

	public function carte($pays = null, $region = null, $paginate = 10){


		$pays_id = PaysTraduction::whereNom( $pays )->pluck('pays_id');
		$region_id = RegionTraduction::whereNom( $region )->pluck('region_id');
		
		$proprietes = Propriete::with(array('proprieteTraduction',
			'localite',
			'sousRegion.sousRegionTraduction',
			'region.regionTraduction',
			'pays.paysTraduction',
			'tarif',
			'typeBatiment.typeBatimentTraduction',
			'photoPropriete'=>function($query){
				$query->whereOrdre('1');
			}
			))
		->where( 'etape','!=','' )
		->whereStatut( 1 )
		->where( 'pays_id', 23 )//23 $pays_id
		->where( 'region_id', 1 )//1 $region_id
		->orderBy('created_at','desc')
		->remember(60 * 24)
		->paginate( $paginate );

		$imageType = imageType::whereNom(Config::get('var.image_standard'))->first();

		return View::make('listing.index',array('page'=>'listing'))
		->with(compact('proprietes','imageType'));
		
	}

}