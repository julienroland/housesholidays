@extends('layout.layout')

@section('container')

@if($commentaires->count())

@foreach($commentaires as $commentaire)

<div style="{{$commentaire->statut == 0 ? 'background-color:red;' : ''}}text-align: left; display: block;">
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

	@if($commentaire->statut == 1 )

	<a href="{{route('desactiverCommentaire', array(Auth::user()->slug, $commentaire->id))}}">{{trans('general.desactiver')}}</a>

	@else

	<a href="{{route('activerCommentaire', array(Auth::user()->slug, $commentaire->id))}}">{{trans('general.activer')}}</a>
	
	@endif

@endforeach


@endif

@stop

