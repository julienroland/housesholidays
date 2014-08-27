<?php

class Admin_ProprieteController extends \Admin_BaseController
{
	public function index()
	{
		$input = Input::all();

		$proprietes = Propriete::with(array(
			'proprieteTraduction',
			'user',
			));

		if(isset( $input['filtre']) ) {
			$proprietes = $proprietes
			->orderBy($input["filtre"], $input['ordre']);
		}

		if(isset( $input['q']) ) {
			$proprietes = $proprietes
			->where('id', 'LIKE' , '%'.$input['q'].'%')
			->orWhere('nom', 'LIKE' , '%'.$input['q'].'%')
			->orWhere('slug', 'LIKE' , '%'.$input['q'].'%');
		}

		$proprietes = $proprietes
		->where( 'etape','!=','' )
		->orderBy('created_at','desc');
		$proprietes = $proprietes
		->paginate( 3 );

		return View::make('admin.propriete.index')
		->with(compact('proprietes'));
	}

	public function desactiver( $id ){

		$propriete = Propriete::find( $id );

		if( $propriete ){

			$propriete->statut = 0;
			$propriete->save();

			return Response::json(array('success'=>'Propriete bien désactive'));
		}
		else{

			return Response::json(array('error'=>'Erreur interne'));

		}
	}
	public function activer( $id ){

		$propriete = Propriete::findOrFail( $id );

		if( $propriete ){

			$propriete->statut = 1;
			$propriete->save();

			return Response::json(array('success'=>'Propriete bien activé'));
		}
		else{

			return Response::json(array('error'=>'Erreur interne'));

		}
	}

	public function deverifier( $id ){

		$propriete = Propriete::find( $id );

		if( $propriete ){

			$propriete->verifier = 0;
			$propriete->save();

			return Response::json(array('success'=>'Annulation de la vérification de la propriete bien effectuée '));
		}
		else{

			return Response::json(array('error'=>'Erreur interne'));

		}
	}

	public function verifier( $id ){

		$propriete = Propriete::find( $id );

		if( $propriete ){

			$propriete->verifier = 1;
			$propriete->save();

			return Response::json(array('success'=>'Activation de la vérification de la propriete bien effectuée '));
		}
		else{

			return Response::json(array('error'=>'Erreur interne'));

		}
	}
}