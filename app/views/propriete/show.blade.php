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

			</div>

			<a href="javascript:void(0)" onclick='adToFav("2182",this,1)' class="favoris"><img src="{{Config::get('var.image_folder')}}ico.coeur.png" alt="" /> <span>{{trans('locationList.favoris')}}</span></a>
		</div>

		<div id="proprietaire"> <span id="titre-proprietaire">{{trans('locationList.propriétaire')}} :</span>
			<ul id="coordonee-proprietaire">
				<li><strong>Nom :</strong><br />
					{{$user->prenom}} {{$user->nom}}</li>
					<li><strong>Téléphone :</strong><br />
						003236652069          </li>
						<li><strong>Langues parlées :</strong><br />
							<img src="{{Config::get('var.image_folder')}}flags/english.png" alt="english" title="english" /> <img src="{{Config::get('var.image_folder')}}flags/spanish.png" alt="spanish" title="spanish" /> <img src="{{Config::get('var.image_folder')}}flags/french.png" alt="french" title="french" /> <img src="/{{Config::get('var.image_folder')}}flags/dutch" alt="dutch" title="dutch" /> <img src="/{{Config::get('var.image_folder')}}flags/german" alt="german" title="german" />                       </li>
						</ul>
						<!--end coordonee-proprietaire--> 

						<a id="contact-proprietaire" class="contactadvertiser" href="lib.syn/contactadvertiser.php?advertiserid=2166&ref=LLMWU3&id=2182">Contacter le propriétaire</a>

					</div>
					<!--end proprietaire--> 
				</div>

			</div>

			<div id="quisommesnous">
				<!-- Tabs -->
				<ul class="tabs">
					<li><a class="active" href="#tabs-1"><span>Description</span></a></li>
					<li><a href="#tab-2"><span>Localisation</span></a></li>
					<li><a href="#tabs-3"><span>Disponibilitées</span></a></li>
					<li><a href="#tab-4"><span>Video</span></a></li>
					<li><a href="#tabs-5"><span>Commentaires</span></a></li>
				</ul>
				
				<div class="tab_container">
					<div id="tabs-1" class="tab_content">
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
								<tr>
									<td>Type de bien:</td>
									<td>{{$propriete->typeBatiment->typeBatimentTraduction[0]->nom}}</td>
								</tr>
								<tr>
									<td>Chambres:</td>
									<td>{{$propriete->nb_chambre}}</td>
								</tr>
								<tr>
									<td>Surface:</td>
									<td>{{$propriete->taille_bien}} m2</td>
								</tr>
								<tr>
									<td>Personnes:</td>
									<td>{{$propriete->nb_personne}}</td>
								</tr>
								<tr>
									<td>Orientation:</td>
									<td></td>
								</tr>
								<tr>
									<td>Vue sur:</td>
									<td>

										@if(Helpers::isOk( $situations ))

										@for($i=0; $i < $situations->count; $i++ )
		
										{{$situations->data[$i]->nom}}
										@if(Helpers::isNotLast($i+1, $situations->count))
										{{(',')}}
										@endif
										@endfor

										@endif

									</td>
								</tr>
								<tr>
									<td>Adresse:</td>
									<td>{{$propriete->adresse}}</td>
								</tr>
								<tr>
									<td>Composition:</td>
									<td>{{$propriete->nb_chambre}}</td>
								</tr>
								<tr>
									<td>Literie:</td>
									<td>

										@if(Helpers::isOk( $literies->data ))

										@for($i=0; $i < $literies->count; $i++)

										{{$literies->data[$i]->valeur}} {{$literies->data[$i]->nom}}
										@if(Helpers::isNotLast($i+1, $literies->count))
										{{(',')}}
										@endif
										@endfor

										@endif
									</td>
								</tr>
								<tr>
									<td>Appareils:</td>
									<td></td>
								</tr>
								<tr>
									<td>Equipement multimédia:</td>
									<td></td>
								</tr>

								<tr>
									<td>Equipement extérieur:</td>
									<td>
										@if(Helpers::isOk( $exterieurs->data ))

										@for($i = 0; $i< $exterieurs->count; $i++)

										{{$exterieurs->data[$i]->valeur}} {{$exterieurs->data[$i]->nom}}
										@if(Helpers::isNotLast($i+1, $exterieurs->count))
										{{(',')}}
										@endif

										@endfor

										@endif
									</td>
								</tr>
								<tr>
									<td>Activités:</td>
									<td>{{$propriete->nb_chambre}}</td>
								</tr>
								<tr>
									<td>Jour d'arrivée:</td>
									<td>{{$propriete->nb_chambre}}</td>
								</tr>
								<tr>
									<td>Frais de nettoyage:</td>
									<td>{{$propriete->nb_chambre}}</td>
								</tr>
								<tr>
									<td>Caution:</td>
									<td>{{$propriete->nb_chambre}}</td>
								</tr>
								<tr>
									<td>Conditions de paiement:</td>
									<td>{{$propriete->nb_chambre}}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div id="tabs-2" class="tab_content"></div>
					<div id="tabs-3" class="tab_content"></div>
					<div id="tabs-4" class="tab_content"></div>
					<div id="tabs-5" class="tab_content"></div>
				</div>

				<!-- Tabs -->
			</div>
		</div>

		@endif
		@stop