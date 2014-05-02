@extends('layout.layout')

@section('container')

@if($propriete->count())
<a id="back" href="javascript: history.go(-1)">{{trans('general.back')}}</a>
<div id="detail-principal">
	<!-- Galerie -->
	<div id="galerie">

		<a href="" class="galerie">
			@if(Helpers::isOk($propriete->photoPropriete))

			@foreach( $propriete->photoPropriete as $photo)

			@if($photo->ordre == 1)

			<img src="/{{Config::get('var.upload_folder')}}{{$propriete->user_id}}/{{Config::get('var.propriete_folder')}}/{{$propriete->id}}/{{Helpers::addBeforeExtension($photo->url,$imageAccrocheType->nom)}}" width="{{$imageAccrocheType->width}}" height="{{$imageAccrocheType->height}}"  id="photo-detail">

			@endif

			@endforeach

			@else

			<img src="{{Config::get('var.image_folder')}}noimage.jpg" width="{{$imageAccrocheType->width}}" height="{{$imageAccrocheType->height}}"  id="photo-detail">

			@endif
		</a>
		<div class="jcarousel-detail-prev">
			{{trans('general.precedent')}}
		</div>
		<div id="galerie-slider">
			<ul id="photo-detail-min">
				@if(Helpers::isOk($propriete->photoPropriete))

				@foreach( $propriete->photoPropriete as $photo)

				@if($photo->ordre != 1)

				<li>
					<a href="" class="galerie"><img src="/{{Config::get('var.upload_folder')}}{{$propriete->user_id}}/{{Config::get('var.propriete_folder')}}/{{$propriete->id}}/{{Helpers::addBeforeExtension($photo->url,$imageSliderType->nom)}}" width="{{$imageSliderType->width}}" height="{{$imageSliderType->height}}" ></a>
				</li>
				@endif
				@endforeach
				@endif

			</ul>
		</div>
		<div class="jcarousel-detail-next">
			{{trans('general.suivant')}}
		</div>
	</div>
	<!-- END Galerie -->
	<div id="infos">
		<!-- Titre -->

		<div id="titre-infos">
			<h1>
				{{trans('general.locationsVacances')}} 
				{{$propriete->typeBatiment->typeBatimentTraduction[0]->nom}} {{trans('general.à')}} {{ucfirst(strtolower($propriete->localite->nom))}} <span>
				@if( isset($propriete->localite->nom) && isset($propriete->sousRegion->sousRegionTraduction[0]->nom) && isset($propriete->region->regionTraduction[0]->nom) && isset($propriete->pays->paysTraduction[0]->nom) )
				(
				{{ucfirst(strtolower($propriete->localite->nom))}} - 
				{{$propriete->sousRegion->sousRegionTraduction[0]->nom}} -
				{{$propriete->region->regionTraduction[0]->nom}}-
				{{$propriete->pays->paysTraduction[0]->nom}}				  
				)
				@endif
			</span></h1>

		</div>
		<!-- END Titre -->

		<div id="description">
			<p id="reference">{{trans('locationList.ref')}} {{$propriete->id}}</p>


			<!-- Caracteristique -->
			<ul id="caracteristique">

				<li id="detail-personne">
					@if($propriete->nb_personne)
					{{$propriete->nb_personne}} @if($propriete->nb_personne > 1) {{trans('general.personnes')}} @else {{trans('general.personne')}} @endif
					@endif
				</li>
				<li id="detail-chambre">{{$propriete->nb_chambre}}  @if($propriete->nb_chambre > 1) {{trans('general.chambres')}} @else {{trans('general.chambre')}} @endif</li>
				<li id="detail-douche"> 
					{{$propriete->nb_sdb}} @if($propriete->nb_sdb > 1) {{trans('general.sdbs')}} @else {{trans('general.sdb')}} @endif
				</li>
				<li id="detail-superficie">
					@if(Helpers::isOk( $propriete->taille_bien ))

					{{round($propriete->taille_bien)}} {{trans('general.superficie')}}
					m<sup>2</sup>

					@endif
				</li>
			</ul>
			<!-- END Caracteristique -->
			<div id="addthis">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style "> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a> <a class="addthis_button_email"></a> <a class="addthis_button_print"></a> <a class="addthis_button_favorites"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a> </div>
				<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-4ef19d4f57cf4b0a"></script> 
				<!-- AddThis Button END --> 
			</div>

			<!--end addthis-->
			<div class="tarif">

				@if($minPrice != $maxPrice)

				<p>{{trans('locationList.de')}} {{round($minPrice)}} &agrave; {{round($maxPrice)}} &euro;<span>/{{trans('locationList.semaine')}}</span></p>

				@else

				<p>{{round($minPrice)}} &euro;<span>/{{trans('locationList.semaine')}}</span></p>

				@endif
				@if(Auth::check())
				<a href="{{route('addFavoris')}}" class="favoris addFavoris" data-userId="{{Auth::user()->id}}" data-proprieteId="{{$propriete->id}}" ><img src="{{Config::get('var.image_folder')}}ico.coeur.png" alt="" /> <span>{{trans('locationList.favoris')}}</span></a>
				@endif
			</div>
			
		</div>

		<div id="proprietaire"> <span id="titre-proprietaire">{{trans('locationList.propriétaire')}} :</span>
			<ul id="coordonee-proprietaire">
				<li><strong>{{trans('general.nom')}} :</strong><br />
					{{$user->prenom}} {{$user->nom}}</li>
					<li><strong>{{trans('general.phone')}} :</strong><br />
						{{Helpers::wellDisplayPhone($tel1->numero)}}</li>
						<li><strong> {{trans('general.langue_parle')}}:</strong><br />

							@if(isset($maternelle) && Helpers::isOk($maternelle))

							<img src="{{Config::get('var.image_folder')}}flags/{{$maternelle->nom}}.png" alt="{{$maternelle->nom}}" title="{{$maternelle->nom}}">

							@endif

							@foreach($langues as $key => $langue) 

							@if( $key != $user->maternelle_id )

							<img src="{{Config::get('var.image_folder')}}flags/{{$langue}}.png" alt="{{$langue}}" title="{{$langue}}">

							@endif

							@endforeach
							
						</li>
					</ul>
					<!--end coordonee-proprietaire--> 

					<a id="contact-proprietaire" class="inline lightbox contactadvertiser" href="#contact">Contacter le propriétaire</a>
					<div style="display:none;">
						
						<div id="contact">
							{{Form::open(array('route'=>'sendMessage','id'=>'sendMessage'))}}
							{{Form::text('arrive','',array('placeholder'=>trans('form.arrive'),'class'=>'date'))}}
							{{Form::text('depart','',array('placeholder'=>trans('form.depart'),'class'=>'date'))}}

							{{Form::text('nom',isset(Auth::user()->nom) ? Auth::user()->nom:'',array('placeholder'=>trans('form.nom').'*','required'))}}
							{{Form::text('prenom',isset(Auth::user()->prenom) ? Auth::user()->prenom:'',array('placeholder'=>trans('form.prenom').'*','required'))}}
							{{Form::email('email',isset(Auth::user()->email) ? Auth::user()->email:'',array('placeholder'=>trans('form.email').'*','required'))}}

							{{Form::text('tel','',array('placeholder'=>trans('form.phone')))}}
							{{Form::text('address',isset(Auth::user()->adresse) ? Auth::user()->adresse:'',array('placeholder'=>trans('form.adresse')))}}

							{{Form::textarea('message','',array('placeholder'=>trans('form.message').'*','required'))}}

							{{Form::hidden('sender_id', Auth::check()  ? Auth::user()->id: '')}}
							{{Form::hidden('propriete_id',$propriete->id)}}
							{{Form::hidden('receiver_id',$user->id)}}

							{{Form::submit(trans('form.button_send'))}}
							{{Form::close()}}

						</div> 

					</div>

				</div>
				<!--end proprietaire--> 
			</div>

		</div>

		<div id="quisommesnous">
			<div class="tabs">
				<!-- Tabs -->
				<ul class="tabs">
					<li><a  href="#tabs-1"><span>Description</span></a></li>
					<li><a href="#tab-2"><span>Localisation</span></a></li>
					<li><a href="#tabs-3"><span>Disponibilitées</span></a></li>
					@if(Helpers::isOk( $propriete->video ))	
					<li><a href="#tab-4"><span>Video</span></a></li>
					@endif
					<li><a href="#tabs-5"><span>Commentaires</span></a></li>
				</ul>

				<div class="tab_container">
					<div id="tabs-1" class="description_propriete tab_content">
						<!-- <span id="titre-description"></span> -->
						<p>
							@foreach($propriete->proprieteTraduction as $traduction)
							@if($traduction->cle ==='description')
							<h2 id="titre-description">
								{{$traduction->valeur}}
							</h2>
							@endif
							@endforeach
						</p>

						<table>
							<tbody>
								@if(Helpers::isOk($propriete->typeBatiment->typeBatimentTraduction[0]->nom))
								<tr>
									<td>Type de bien:</td>
									<td>{{$propriete->typeBatiment->typeBatimentTraduction[0]->nom}}</td>
								</tr>
								@endif
								@if(Helpers::isOk($propriete->nb_chambre))
								<tr>
									<td>Chambres:</td>
									<td>{{$propriete->nb_chambre}}</td>
								</tr>
								@endif
								@if(Helpers::isOk($propriete->taille_bien))
								<tr>
									<td>Surface:</td>
									<td>{{$propriete->taille_bien}} m2</td>
								</tr>
								@endif
								@if(Helpers::isOk($propriete->nb_personne))
								<tr>
									<td>Personnes:</td>
									<td>{{$propriete->nb_personne}}</td>
								</tr>
								@endif
								@if(Helpers::isOk($propriete->exposition))

								<tr>
									<td>Orientation:</td>
									<td>{{trans('form.expositionList')[$propriete->exposition]}}</td>
								</tr>
								@endif

								@if(Helpers::isOk( $situations ))
								<tr>
									<td>Vue sur:</td>
									<td>



										@for($i=0; $i < $situations->count; $i++ )

										{{$situations->data[$i]->nom}}
										@if(Helpers::isNotLast($i+1, $situations->count))
										{{(',')}}
										@endif
										@endfor



									</td>
								</tr>
								@endif
								@if(Helpers::isOk($propriete->adresse))
								<tr>
									<td>Adresse:</td>
									<td>{{$propriete->adresse}}</td>
								</tr>
								@endif
								@if(Helpers::isOk($propriete->nb_chambre))
								<tr>
									<td>Composition:</td>
									<td>{{$propriete->nb_chambre}}</td>
								</tr>
								@endif
								@if(Helpers::isOk( $literies->data ))
								<tr>
									<td>Literie:</td>
									<td>
										@for($i=0; $i < $literies->count; $i++)

										{{$literies->data[$i]->valeur}} {{$literies->data[$i]->nom}}
										@if(Helpers::isNotLast($i+1, $literies->count))
										{{(',')}}
										@endif
										@endfor


									</td>
								</tr>
								@endif
								<tr>
									<td>Appareils:</td>
									<td></td>
								</tr>
								<tr>
									<td>Equipement multimédia:</td>
									<td></td>
								</tr>

								@if(Helpers::isOk( $exterieurs->data ))

								<tr>
									<td>Equipement extérieur:</td>
									<td>

										@for($i = 0; $i< $exterieurs->count; $i++)

										{{$exterieurs->data[$i]->valeur}} {{$exterieurs->data[$i]->nom}}
										@if(Helpers::isNotLast($i+1, $exterieurs->count))
										{{(',')}}
										@endif

										@endfor


									</td>
								</tr>

								@endif

								<tr>
									<td>Activités:</td>
									<td></td>
								</tr>

								@if( $jour_arrive !== 0)
								<tr>
									<td>Jour d'arrivée:</td>
									@if(Helpers::isNotOk($jour_arrive))
									<td>Tout jour</td>
									@else 
									<td>{{trans('general.jours')[$jour_arrive]}}</td>
									@endif
								</tr>
								@endif

								@if(Helpers::isOk($propriete->nettoyage))
								<tr>
									<td>Frais de nettoyage:</td>
									<td>{{$propriete->nettoyage}}€</td>
								</tr>
								@endif

								@if(Helpers::isOk($propriete->nettoyage))
								<tr>
									<td>Caution:</td>
									<td>{{$propriete->caution}}€</td>
								</tr>
								@endif

								@if(Helpers::isOk($propriete->nettoyage))
								<tr>
									<td>Conditions de paiement:</td>
									<td>{{$propriete->condition_paiement}}</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
					<div id="tabs-2" class="localisation tab_content">
						<div id="gmap" data-location="{{$propriete->latlng}}"></div>
					</div>
					<div id="tabs-3" class="tab_content">
						<div class="dispo"><div class="color"></div>Disponible</div>
						<div class="nondispo"><div class="color"></div>Non disponible</div>
						{{$calendrier}}
					</div>
					<div id="tabs-4" class="tab_content">
						<a href="{{$propriete->video}}">{{$propriete->video}}</a>
					</div>
					<div id="tabs-5" class="tab_content">
						@if(Auth::guest())
						<div id="suggestion_pan">
							{{trans('general.vous_devez_connecter')}}
						</div>
						@endif

						@if(Helpers::isOk($commentaires))

						@foreach($commentaires as $commentaire)
						
						<div style="text-align: left; display: block;">
							<span style="margin-left: 10px;">{{trans('locationList.note')}}</span>
							@if(Helpers::isOk($commentaire->note))
							@for( $i = 0; $i < $commentaire->note; $i++)
							<img src="{{Config::get('var.image_folder')}}rating-hv.png" alt="">
							@endfor
							@endif
							<div class="fontNormal" style="padding: 10px; background-color: rgb(249, 249, 249); margin-bottom: 1px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(241, 241, 241); display: block; background-position: initial initial; background-repeat: initial initial;">
								
								<div style="padding-bottom: 5px; display: block;">
									<span style="color:#666666">
										<span>{{trans('locationList.publie_par')}}</span>
										<strong style="color:#0099FF;">{{$commentaire->user->prenom}} {{$commentaire->user->nom}}</strong>
									</span>
								</div>
								<div style="padding-bottom: 10px; color: rgb(102, 102, 102); display: block;" class="fontSmall">
									<span>{{trans('locationList.poste')}}</span>
									{{Helpers::toHumanDiff($commentaire->created_at)}}
								</div>
								<p>{{$commentaire->text}}</p>
							</div>
						</div>
						@endforeach
						@endif
						@if(Auth::check())

						{{Form::open(array('route'=>'sendCommentaire'))}}
						{{Form::label('titre',trans('form.enter_titre'))}}
						{{Form::text('titre', '',array('required','placeholder'=>trans('form.impression_general')))}}
						

						{{Form::label('date',trans('form.enter_date_sejour'))}}
						{{Form::text('date','', array('class'=>'date','required'))}}

						{{Form::label('note',trans('form.enter_note'))}}
						<div class="note_propriete">

							<label for="note1" >

								{{Form::radio('note','1',array('id'=>'note1'))}}	

							</label>
							
							<label for="note2" >

								{{Form::radio('note','2',array('id'=>'note2'))}}	

							</label>	
							
							<label for="note3">

								{{Form::radio('note','3',array('id'=>'3note3'))}}	

							</label>

							<label for="note4">

								{{Form::radio('note','4',array('id'=>'note4'))}}	

							</label>

							<label for="note5">

								{{Form::radio('note','5',array('id'=>'note5'))}}	

							</label>

						</div>

						{{Form::label('commentaire',trans('form.enter_comm'))}}
						{{Form::textarea('commentaire', '', array('required','placeholder'=>trans('form.text')))}}

						{{Form::hidden('user_id',Auth::user()->id)}}
						{{Form::hidden('propriete_id',$propriete->id)}}

						{{Form::submit(trans('form.button_send'))}}

						{{Form::close()}}
						@else

						{{trans('locationList.comm_co')}}

						@endif

					</div>
				</div>
			</div>

			<!-- Tabs -->
		</div>
	</div>
	@endif
	@stop