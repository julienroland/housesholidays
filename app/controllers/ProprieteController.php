<?php

use Carbon\Carbon;

class ProprieteController extends BaseController {

	public function show( $idOrSlug ){

		Cache::forget('propriete'.$idOrSlug);

		if(!is_object($idOrSlug)) {

			$idOrSlug = Propriete::whereSlug($idOrSlug)->firstOrFail();
		}
		$propriete = Helpers::cache(Propriete::getLocations( $idOrSlug ),'propriete'.$idOrSlug);

		$date = date('n');
		$today = Carbon::now();

		if(!Cache::has('calendrier')){

			$calendrier = '';

			for($i = $date; $i < ($date +Config::get('var.mois')); $i++ ){

				$calendrier = $calendrier.Helpers::build_calendar( $today->month, $today->year, $propriete->id );

				$today = $today->addMonth();
			}

			Cache::put('calendrier'.$idOrSlug, $calendrier, 60 * 24);

		}
		else{

			$calendrier = Cache::get('calendrier'.$idOrSlug);

		}

		$user = Helpers::cache($propriete->user()->with('langage')->first(), 'user'.$propriete->user()->pluck('id'));

		/**

			TODO:
			- bug ici
			- Second todo item

		**/


		$tel1 = Helpers::cache($user->telephone()->whereOrdre(1)->first(),'tel1'.$user->id);

		/*$tel2 = $user->telephone()->whereOrdre(2)->first();*/

		$langues = Helpers::cache(User::getLangages( $user ),'langues'.$user->id);

		$maternelle = Helpers::cache(Langage::find( $user->maternelle_id ),'maternelle'.$user->id);

		$commentaires = Commentaire::with('user')->whereProprieteId( $propriete->id)->whereStatut(1)->remember( 60 * 24 , 'commentaires'.$propriete->id )->get();

		$minPrice = Helpers::cache(Propriete::getMinTarif( $propriete, Config::get('var.semaine_col')),'minPrice'.$propriete->id);

		$maxPrice = Helpers::cache(Propriete::getMaxTarif( $propriete, Config::get('var.semaine_col')),'maxPrice'.$propriete->id);

		$imageAccrocheType = Helpers::cache(imageType::whereNom(Config::get('var.image_standard'))->remember(60 * 24)->first(), 'imageAccrocheType');

		$imageSliderType = Helpers::cache(imageType::whereNom(Config::get('var.image_thumbnail'))->remember(60 * 24)->first(), 'imageSliderType');

		/*$options = Propriete::getOptions( $idOrSlug );*/

		$tarifs = Helpers::cache($propriete->with('tarif')->whereId($propriete->id)->remember(60 * 24 )->first(), 'tarifs'.$propriete->id);

		$jour_arrive = 0;

		$currentTarif = null;

		foreach($tarifs->tarif as $tarif){

			$debut = Helpers::createCarbonDate($tarif->date_debut);
			$fin = Helpers::createCarbonDate($tarif->date_fin);

			if(Helpers::isOk($tarif->date_debut) && Helpers::isOk($tarif->date_debut))

				if(Helpers::isOk($debut) && Helpers::isOk($fin)){

					if($today->between($debut, $fin)){

						$currentTarif = $tarif;
						$jour_arrive = $currentTarif->jour_arrive_id;
					}
				}
			}

			$situations = Helpers::cache(Propriete::getSituations( $idOrSlug ),'situations'.$propriete->id);

			$literies = Helpers::cache(Propriete::getLiterie( $idOrSlug ),'literie'.$propriete->id);

			$exterieurs = Helpers::cache(Propriete::getExterieur( $idOrSlug ),'exterieurs'.$propriete->id);

			$interieurs = Helpers::cache(Propriete::getInterieur( $idOrSlug ),'interieur'.$propriete->id);


			return View::make('propriete.show', array(
				'page'=>'showPropriete',
				'widget'=>array(
					'carousel',
					'showMap',
					'tab',
					'datepicker',
					'lightbox')))
			->with(compact(array(
				'propriete',
				'imageType',
				'imageAccrocheType',
				'imageSliderType',
				'minPrice',
				'maxPrice',
				'user',
				'options',
				'situations',
				'literies',
				'exterieurs',
				'interieurs',
				'tel1',
				'langues',
				'jour_arrive',
				'today',
				'date',
				'commentaires',
				'maternelle',
				'calendrier',
				)));
		}
		public function delete( $id ){

			$propriete = Propriete::find($id);

			$user_id = $propriete->user()->pluck('id');

			if( Auth::user()->id === $propriete->user_id  || Auth::user()->role_id > 1){

				$propriete->option()->detach();

				$propriete->calendrier()->delete();

				$propriete->commentaire()->delete();

				$propriete->tarif()->delete();

				$propriete->photoPropriete()->delete();

				$propriete->favoris()->delete();

				$propriete->message()->delete();

				ProprieteTraduction::whereProprieteId( $propriete->id )->delete();

				$propriete->delete();

				File::deleteDirectory( Config::get('var.upload_folder').$user_id.'/proprietes/'.$propriete->id );

				Cache::forget('proprietes');

				Propriete::getLocations();

				return Redirect::back();

			}
			else{

				return Redirect::back();
			}


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