<?php

class InscriptionController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function informationsPersos()
	{
		$input = Input::all();
		$rules = array(
			'prenom'=>'',
			'nom'=>'',
			'email'=>'email|required',
			'pays'=>'',
			'mot_de_passe'=>'required|min:3',
			'verification_mot_de_passe'=>'same:mot_de_passe|required',
			'condition_general_de_vente'=>'accepted',
			);

		$validation = Validator::make($input,$rules);
		if($validation->passes()){

			return Redirect::to('inscription/description-du-bien')
			->with('success','Vos informations sont bien enregistrées, vous allez être rediriger sur l\'étape suivante');

		}
		else{
			return Redirect::to('inscription')
			->withInput()
			->withErrors($validation);
			
			
		}
	}

}