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
			
			/**
			*
			* ^ RETIRER LES "S" DE FIN DANS USERS et PROPRIETES  ^
			*
			**/

			$commentaire->save();

			if(Cache::has('commentaires')){

				Cache::forget('commentaires');

			}

			return Redirect::intended('showPropriete', $input['propriete_id']);

		}else{

			return Redirect::intended('showPropriete', $input['propriete_id'])
			->withInput()
			->withErrors( $validator );

		}
		

	}

	public function sendMessage(){

		$input = Input::all();

		$validator = Validator::make( $input, User::$mess_rules, array('different'=>trans('validation.custom.send_message_to_you')) );

		if( $validator->passes() ){

			$message = new Message;

			$message->arrive = $input['arrive'];
			$message->depart = $input['arrive'];
			$message->nom = $input['arrive'];
			$message->prenom = $input['arrive'];
			$message->email = $input['arrive'];
			$message->telephone = $input['arrive'];
			$message->adresse = $input['arrive'];
			$message->de_user_id = $input['sender_id'];
			$message->vers_user_id = $input['receiver_id'];
			$message->propriete_id = $input['propriete_id'];
			
			$message->save();

			if(Cache::has('messages')){

				Cache::forget('messages');
				
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

}