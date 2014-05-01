<?php

class Admin_ProprieteController extends \Admin_BaseController
{
	public function index()
	{
		$proprietes = Propriete::with(array(
			'proprieteTraduction',
			'user',
			))
		->where( 'etape','!=','' )
		->orderBy('created_at','desc')
		->remember(60 * 24)
		->get(  );

		return View::make('admin.propriete.index')
		->with(compact('proprietes'));
	}

	public function desactiver( $id ){

		$propriete = Propriete::find( $id );

		if( $propriete ){

			$propriete->statut = 0;
			$propriete->save();

			return Redirect::route('listLocations')
			->with(array('success'=>'Propriete bien désactive'));
		}
		else{

			return Redirect::route('listLocations')
			->with(array('error'=>'Erreur interne'));

		}
	}

	public function deverifier( $id ){

		$propriete = Propriete::find( $id );

		if( $propriete ){

			$propriete->verifier = 0;
			$propriete->save();

			return Redirect::route('listLocations')
			->with(array('success'=>'Annulation de la vérification de la propriete bien effectuée '));
		}
		else{

			return Redirect::route('listLocations')
			->with(array('error'=>'Erreur interne'));

		}
	}
}