<?php

class UserController extends BaseController {

	public function sendCommentaire( ){

		$input = Input::all();

		$validator = Validator::make( $input, User::$comm_rules );

		if( $validator->passes() ){

			$commentaire = new Commentaire;

			$commentaire->titre = $input['titre'];
			$commentaire->date_sejour = Helpers::toServerDate($input['date']);
			$commentaire->note = $input['note'];
			$commentaire->text = $input['commentaire'];
			$commentaire->user_id = $input['user_id']; 
			$commentaire->propriete_id = $input['propriete_id'];
			$commentaire->statut = 1;

			$commentaire->save();

			if(Cache::has('commentaires'.$input['propriete_id'])){

				Cache::forget('commentaires'.$input['propriete_id']);

			}

			return Redirect::route('showPropriete', $input['propriete_id']);

		}else{

			return Redirect::route('showPropriete', $input['propriete_id'])
			->withInput()
			->withErrors( $validator );

		}
		

	}

	public function sendMessage(){

		$input = Input::all();

		$validator = Validator::make( $input, User::$mess_rules, array('different'=>trans('validation.custom.send_message_to_you')) );

		if( $validator->passes() ){

			$message = new Message;

			if(Helpers::isOk( $input['arrive'])){

				$message->arrive = Helpers::toServerDate($input['arrive']);

			}

			if(Helpers::isOk( $input['depart'])){

				$message->depart = Helpers::toServerDate($input['depart']);

			}

			$message->nom = $input['nom'];
			$message->prenom = $input['prenom'];
			$message->email = $input['email'];
			$message->telephone = $input['tel'];
			$message->texte = $input['message'];
			$message->adresse = $input['address'];

			if(Helpers::isOk( $input['sender_id'] )){

				$message->de_user_id = $input['sender_id'];

			}

			$message->vers_user_id = $input['receiver_id'];
			$message->propriete_id = $input['propriete_id'];
			
			$message->save();

			$user = User::find((int)$input['receiver_id']);

			/*Mail::send('emails.new_message', array('user'=>$message), function($message) use($user)
			{
				$message
				->to( $user->email )
				->cc( $user->email )
				->subject(trans('general.new_message'));

			});*/

if(Cache::has('messages'.$input['propriete_id'])){

	Cache::forget('messages'.$input['propriete_id']);

}

return Response::json(trans('general.message_send'), 200 );

}else{


	return Response::json( $validator->messages() , 400 );

}
}

public function repondreMessage( ){

	$input = Input::all();

	$tel = Auth::user()->telephone()->where('ordre',1)->pluck('numero');

	$validator = Validator::make( $input, User::$messRep_rules, array('different'=>trans('validation.custom.send_message_to_you')) );

	if( $validator->passes() ){
		$message = new Message;

		$message->nom = Auth::user()->nom;
		$message->prenom = Auth::user()->prenom;
		$message->email = Auth::user()->email;
		$message->telephone = $tel;
		$message->texte = $input['message'];
		$message->adresse = Auth::user()->adresse;
		$message->de_user_id = $input['sender_id'];

		if(Helpers::isOk($input['receiver_id']))
		{

			$message->vers_user_id = $input['receiver_id'];

		}

		$message->reponse_id = $input['message_id'];
		$message->propriete_id = $input['propriete_id'];

		$message->save();

		$receiver = Message::find((int)$input['message_id']);

			/*Mail::send('emails.reponse_message', array('user'=>$message), function($message) use($receiver)
			{
				$message
				->to( $receiver->email )
				->cc( $receiver->email )
				->subject(trans('general.reponse_message'));

			});*/

if(Cache::has('messages'.$input['propriete_id'])){

	Cache::forget('messages'.$input['propriete_id']);

}

return Response::json(trans('general.message_send'), 200 );

}else{


	return Response::json( $validator->messages() , 400 );

}


}

public function addFavoris($user_id = null, $propriete_id = null){

	if(Helpers::isOk($user_id) && Helpers::isOk( $propriete_id )){

		if(Auth::check()){

			if(Favoris::whereUserId( $user_id )->whereProprieteId( $propriete_id )->first()){

				return Response::json(trans('validation.custom.favoris_exist_deja'), 200);

			}else{

				$favoris = new Favoris;

				$favoris->propriete_id = $propriete_id;
				$favoris->user_id = $user_id;

				$favoris->save();

				if($favoris){
					
					Cache::forget('favoris'.$user_id);

					return Response::json(trans('validation.custom.favoris_add'), 200);

				}
				else{

					return Response::json(trans('validation.custom.favoris_not_add'), 200);

				}
			}

		}else{

			return Response::json(trans('general.vous_devez_connecter'), 200);
		}

	}

}

public function deleteFavoris($user_id = null, $propriete_id = null){

	if(Helpers::isOk($user_id) && Helpers::isOk( $propriete_id )){

		if(Auth::check()){

			$favoris = Favoris::whereProprieteId( $propriete_id )->whereUserId( $user_id)->delete();

			if($favoris){

				Cache::forget('favoris'.$user_id);

				return Response::json(trans('validation.custom.favoris_delete'), 200);

			}else{
				return Response::json(trans('validation.custom.favoris_not_delete'), 200);
			}
		}else{

			return Response::json(trans('general.vous_devez_connecter'), 200);
		}
	}
}

public function listCommentaires(  ){

	$commentaires = Auth::user()->commentaire()->get();

	return View::make('compte.commentaires', array('page'=>'commentaires'))
	->with(compact('commentaires'));
}

public function desactiverCommentaire( $slug, $id ){

	$commentaire = Commentaire::findOrFail($id);

	if(Helpers::isOwnerOrAdmin($commentaire->user_id)){

		$commentaire->statut = 0;

		$commentaire->save();

		if(Cache::has('commentaires'.$commentaire->propriete_id)){

			Cache::forget('commentaires'.$commentaire->propriete_id);

		}
	}

	return Redirect::route('listCommentaires', Auth::user()->slug)
	->with('success',trans('general.commentaire_desactiver'));
}


public function activerCommentaire( $slug, $id ){

	$commentaire = Commentaire::findOrFail($id);

	if(Helpers::isOwnerOrAdmin($commentaire->user_id)){

		$commentaire->statut = 1;

		$commentaire->save();

		if(Cache::has('commentaires'.$commentaire->propriete_id)){

			Cache::forget('commentaires'.$commentaire->propriete_id);

		}
	}

	return Redirect::route('listCommentaires', Auth::user()->slug)
	->with('success',trans('general.commentaire_activer'));
}

public function listMessage(  ){

	$messagesReceive = Auth::user()->messageReceive()->paginate(10);
	$messagesSend = Auth::user()->messageSend()->paginate(10);

	/*dd(DB::getQueryLog());*/

	return View::make('compte.messages', array('page'=>'messages','widget'=>array('lightbox')))
	->with(compact('messagesReceive','messagesSend'));
}

public function listFavoris(){

	$favoris = Auth::user()->favoris()->with(array(
		'propriete.photoPropriete'=>function($query){
			$query->whereOrdre(1);
		},
		'propriete.localite',
		'propriete.sousRegion.sousRegionTraduction',
		'propriete.region.regionTraduction',
		'propriete.pays.paysTraduction',
		'propriete.tarif',
		'propriete.typeBatiment.typeBatimentTraduction'))
	->remember(60 * 24, 'favoris'.Auth::user()->id)
	->get();

	$imageType = Helpers::cache(imageType::whereNom(Config::get('var.image_thumbnail'))->remember(60 * 24)->first(), 'image_thumbnail');

	

	return View::make('compte.favoris', array('page'=>'favoris'))
	->with(compact(array('favoris','imageType')));
}

}