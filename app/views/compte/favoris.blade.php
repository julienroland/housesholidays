@extends('layout.layout')

@section('container')

@if($favoris->count())

@foreach($favoris as $favori)

<div class="liste-resultat">
	<a href="">
		@if(isset($favori->propriete->photoPropriete[0]) && Helpers::isOk($favori->propriete->photoPropriete[0]))
		<a href="{{route('showPropriete',$favori->propriete->id)}}"><img src="/{{Config::get('var.upload_folder')}}{{$favori->propriete->user_id}}/{{Config::get('var.propriete_folder')}}/{{$favori->propriete->id}}/{{Helpers::addBeforeExtension($favori->propriete->photoPropriete[0]->url,$imageType->nom)}}" width="{{$imageType->width}}" height="{{$imageType->height}}" class="photo-resultat" alt="{{$favori->propriete->photoPropriete[0]->alt}}"></a>
		@else
		<img src="{{Config::get('var.image_folder')}}noimage.jpg" alt="{{trans('listLocation.noImage')}}">
		@endif
		<h3 aria-level="3" role="heading" class="titre-resultat">

			@foreach($favori->propriete->proprieteTraduction as $titre)

			@if($titre->cle === Config::get('var.titre') )	
			@if(Helpers::isOk($titre->cle))
			{{$titre->valeur}}
			@else
			<p class="notPresent">{{trans('locationList.noData')}}</p>
			@endif

			@endif
			@endforeach

			
			<span>
				@if(isset($favori->propriete->localite->nom) || isset($favori->propriete->sousRegion->sousRegionTraduction[0]->nom) || isset($favori->propriete->region->regionTraduction[0]->nom) || isset($favori->propriete->pays->paysTraduction[0]->nom))
				(
				@if(isset($favori->propriete->localite->nom) && Helpers::isOk($favori->propriete->localite->nom)) 
				{{$favori->propriete->localite->nom}}
				@endif

				@if(isset($favori->propriete->sousRegion->sousRegionTraduction[0]->nom) && Helpers::isOk($favori->propriete->sousRegion->sousRegionTraduction[0]->nom)) 
				- {{$favori->propriete->sousRegion->sousRegionTraduction[0]->nom}}
				@endif

				@if(isset($favori->propriete->region->regionTraduction[0]->nom) && Helpers::isOk($favori->propriete->region->regionTraduction[0]->nom)) 
				- {{$favori->propriete->region->regionTraduction[0]->nom}}
				@endif

				@if(isset($favori->propriete->pays->paysTraduction[0]->nom) && Helpers::isOk($favori->propriete->pays->paysTraduction[0]->nom)) 
				- {{$favori->propriete->pays->paysTraduction[0]->nom}}
				@endif
				)
				@else
				{{trans('locationList.noLocation')}}
				@endif
			</span>
			
		</h3>
		<p class="p-resultat">
			@foreach($favori->propriete->proprieteTraduction as $description)
			@if($description->cle === Config::get('var.description'))	
			@if(Helpers::isOk($titre->cle))
			{{$description->valeur}}
			@else
			<p class="notPresent">{{trans('locationList.noData')}}</p>
			@endif

			@endif
			@endforeach
		</p>
		<ul class="caract-resultat">
			<li class="personne">
				@if($favori->propriete->nb_personne)
				{{$favori->propriete->nb_personne}} @if($favori->propriete->nb_personne > 1) {{trans('general.personnes')}} @else {{trans('general.personne')}} @endif
				@endif
			</li>
			<li class="chambre">{{$favori->propriete->nb_chambre}}  @if($favori->propriete->nb_chambre > 1) {{trans('general.chambres')}} @else {{trans('general.chambre')}} @endif</li>
			<li class="detail-douche"> 
				{{$favori->propriete->nb_sdb}} @if($favori->propriete->nb_sdb > 1) {{trans('general.sdbs')}} @else {{trans('general.sdb')}} @endif
			</li>
			<li class="superficie">
				@if(Helpers::isOk( $favori->propriete->taille_bien ))

				{{round($favori->propriete->taille_bien)}} {{trans('general.superficie')}}
				m<sup>2</sup>

				@endif
			</li>

		</ul>

	</a>
	
	<p class="priceSem">
		<?php $minPrice = Helpers::cache(Propriete::getMinTarif( $favori->propriete, Config::get('var.semaine_col')),'minPrice'.$favori->propriete->id);

		$maxPrice = Helpers::cache(Propriete::getMaxTarif( $favori->propriete, Config::get('var.semaine_col')),'maxPrice'.$favori->propriete->id); ?>
		<span>
			@if($minPrice != $maxPrice)

			{{trans('locationList.de')}} {{round($minPrice)}} &agrave; {{round($maxPrice)}} &euro;<span>/{{trans('locationList.semaine')}}</span>

			@else

			{{round($minPrice)}} &euro;<span>/{{trans('locationList.semaine')}}</span>

			@endif
		</span>
	</p>
	@if(Helpers::isNotFavoris($favori->propriete->id, Auth::user()->id))
	<a href="{{route('addFavoris')}}" class="favoris addFavoris" data-userId="{{Auth::user()->id}}" data-proprieteId="{{$favori->propriete->id}}" ><img src="{{Config::get('var.image_folder')}}ico.coeur.png" alt="" /> <span>{{trans('locationList.favoris')}}</span></a>
	@else
	<a href="{{route('deleteFavoris')}}" class="favoris deleteFavoris" data-userId="{{Auth::user()->id}}" data-proprieteId="{{$favori->propriete->id}}" ><img src="{{Config::get('var.image_folder')}}ico.coeur.png" alt="" /> <span class="delfav">{{trans('general.supprimer')}}</span></a>
	@endif

</div>
@endforeach
@else 
<p>{{trans('general.aucun_favoris')}}</p>
@endif

@stop

