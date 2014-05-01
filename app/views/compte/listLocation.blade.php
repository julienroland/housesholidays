@extends('layout.layout')

@section('container')

@if( isset($proprietes ) && Helpers::isOk( $proprietes ))

@foreach( $proprietes as $propriete )

<div class="liste-resultat">
	<a href="">
		@if(isset($propriete->photoPropriete[0]) && Helpers::isOk($propriete->photoPropriete[0]))
		<a href="{{route('showPropriete',$propriete->id)}}"><img src="/{{Config::get('var.upload_folder')}}{{$propriete->user_id}}/{{Config::get('var.propriete_folder')}}/{{$propriete->id}}/{{Helpers::addBeforeExtension($propriete->photoPropriete[0]->url,$imageType->nom)}}" width="{{$imageType->width}}" height="{{$imageType->height}}" class="photo-resultat" alt="{{$propriete->photoPropriete[0]->alt}}"></a>
		@else
		<img src="{{Config::get('var.image_folder')}}noimage.jpg" alt="{{trans('listLocation.noImage')}}">
		@endif
		<h3 aria-level="3" role="heading" class="titre-resultat">

			@foreach($propriete->proprieteTraduction as $titre)

			@if($titre->cle === Config::get('var.titre') )	
			@if(Helpers::isOk($titre->cle))
			{{$titre->valeur}}
			@else
			<p class="notPresent">{{trans('locationList.noData')}}</p>
			@endif

			@endif
			@endforeach

			
			<span>
			@if(isset($propriete->localite->nom) || isset($propriete->sousRegion->sousRegionTraduction[0]->nom) || isset($propriete->region->regionTraduction[0]->nom) || isset($propriete->pays->paysTraduction[0]->nom))
				(
				@if(isset($propriete->localite->nom) && Helpers::isOk($propriete->localite->nom)) 
				{{$propriete->localite->nom}}
				@endif

				@if(isset($propriete->sousRegion->sousRegionTraduction[0]->nom) && Helpers::isOk($propriete->sousRegion->sousRegionTraduction[0]->nom)) 
				- {{$propriete->sousRegion->sousRegionTraduction[0]->nom}}
				@endif

				@if(isset($propriete->region->regionTraduction[0]->nom) && Helpers::isOk($propriete->region->regionTraduction[0]->nom)) 
				- {{$propriete->region->regionTraduction[0]->nom}}
				@endif

				@if(isset($propriete->pays->paysTraduction[0]->nom) && Helpers::isOk($propriete->pays->paysTraduction[0]->nom)) 
				- {{$propriete->pays->paysTraduction[0]->nom}}
				@endif
				)
				@else
				{{trans('locationList.noLocation')}}
				@endif
			</span>
			
		</h3>
		<p class="p-resultat">
			@foreach($propriete->proprieteTraduction as $description)
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
				@if($propriete->nb_personne)
				{{$propriete->nb_personne}} @if($propriete->nb_personne > 1) {{trans('general.personnes')}} @else {{trans('general.personne')}} @endif
				@endif
			</li>
			<li class="chambre">{{$propriete->nb_chambre}}  @if($propriete->nb_chambre > 1) {{trans('general.chambres')}} @else {{trans('general.chambre')}} @endif</li>
			<li class="detail-douche"> 
				{{$propriete->nb_sdb}} @if($propriete->nb_sdb > 1) {{trans('general.sdbs')}} @else {{trans('general.sdb')}} @endif
			</li>
			<li class="superficie">
				@if(Helpers::isOk( $propriete->taille_bien ))

				{{round($propriete->taille_bien)}} {{trans('general.superficie')}}
				m<sup>2</sup>

				@endif
			</li>

		</ul>

	</a>
	
	<p class="priceSem">
		<span>

		</span>
	</p>
{{var_dump($propriete->statut)}}
	<div class="admin">
		<span>{{trans('locationList.total_visite')}}: @if($propriete->nb_visite > 0){{$propriete->nb_visite}} @else {{trans('locationList.noData')}} @endif</span>
		<span>{{trans('locationList.statut')}}: @if($propriete->statut == 0){{trans('locationList.inactive')}} @else {{trans('locationList.active')}} @endif</span>
		<span>{{trans('locationList.last_visite')}}: @if($propriete->nb_visite == 0){{trans('locationList.noData')}} @else {{$propriete->last_visite}} @endif</span>
		<span>{{trans('locationList.last_update')}}: @if(Helpers::isOk($propriete->updated_at)){{Helpers::toHumanDiff($propriete->updated_at)}} @else {{trans('locationList.noData')}} @endif</span>
		<ul>
		
			<li>{{link_to_route('showPropriete',trans('form.voir'), $propriete->id)}}</li>
			<li>{{link_to_route('editPropriete1',trans('form.modifier'), $propriete->id)}}</li>
			<li>{{link_to_route('RefreshAnnonce',trans('locationList.refreshAnnonce'), $propriete->id,array('data-id'=>$propriete->id,'class'=>'refreshAnnonce'))}}</li>
		</ul>
	</div>
</div>
<!-- array($propriete->slug, Helpers::toSlug($propriete->typeBatiment->typeBatimentTraduction[0]->nom) , Helpers::toSlug( $propriete->pays->paysTraduction[0]->nom), Helpers::toSlug($propriete->region->regionTraduction[0]->nom), Helpers::toSlug($propriete->sousRegion->sousRegionTraduction[0]->nom), Helpers::toSlug($propriete->localite->nom)))}}</li>
			 -->
@endforeach

@else

<p>Aucune inscription non-finie</p>

@endif

@stop