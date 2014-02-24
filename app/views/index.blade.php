@extends('layout')

@section('container')

@if(isset($message))
<p>{{$message}}</p>
@endif
@if(isset($validatorMessage))
<p>{{$validatorMessage}}</p>
@endif
@if(Auth::check())
Activité(s) - Dernière(s) visite(s) - dernier(s) message(s)
@else
<div class="intro wrapper">
	<div class="why">
		<h3>{{('Pourquoi choisir Akote.be ?')}}</h3>

		<p>{{('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti, quo, pariatur, dolor aliquam ad odio non praesentium temporibus qui dolorem illum alias est sequi itaque deserunt tempora doloribus quas. Facilis.')}}</p>

	</div>

	<div class="help">
		<h3>{{('Vous pouvez nous aider !')}}</h3>

		<p>{{('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti, quo, pariatur, dolor aliquam ad odio non praesentium temporibus qui dolorem illum alias est sequi itaque deserunt tempora doloribus quas. Facilis.')}}</p>

	</div>
</div>
@endif

<h3>{{('Rechercher un kot')}}</h3>
<div class="icoRecherche">
	<ul>
		<li><span class="link"><a href="#rapide"></a></span><span>Rapide</span></li>
		<li><span class="link"><span>Détaillée</span></li>
	</li>
</ul>
</div>
<div class="wrapper">
	<div id="rapide">
		

		<?php  var_dump(Session::get('ancienneRechercheRapide'));?>
		@if(isset($errorMessage)){{$errorMessage}}@endif
		{{ Form::open(array('url' => 'recherche/rapide/' )) }}
		<div class="content">
			<span>{{('Rechercher par rapport à :')}}</span>
			<div class="type">
				{{Form::radio('type','aucun',false,array('id'=>'aucun'))}}
				{{Form::label('aucun','Aucun filtre')}}

				
				
			</div>
		</div>
		<div id="gmap"></div>
		<div class="mapInfo">
			{{Form::label('map','Indiquez l\'adresse',array('class'=>'map1'))}}
			{{Form::text('zone',Session::get('ancienneRechercheRapide')['zone'],array('id'=>'map','placeholder'=>'Rue code postal,ville'))}}

			{{Form::label('distance','Indiquez le rayon du filtre (celui-ci est en mètre)')}}
			{{Form::text('distance',Session::get('ancienneRechercheRapide')['distance'],array('id'=>'distance','placeholder'=>'ex : 1000 pour 1km'))}}

			{{Form::hidden('coords','',array('id'=>'coords'))}}

			{{ Form::button('Filtrer',array('id'=>'filtrer')) }}
			@if(Auth::check())
			{{Form::label('enregistrer','Enregistrer la recherche')}}
			{{Form::checkbox('enregistrer')}}
			{{Form::label('enregistrerNom','Donnez un nom à votre recherche enregistré (20 charactères maximun)')}}
			{{Form::text('enregistrerNom','',array('placeholder'=>'ex: recherche kot liège'))}}
			@endif

			{{Form::hidden('listKot',json_encode(Session::get('kotFromGoogle')),array('id'=>'listKot'))}}
		</div>
		<!-- <div class="classique">  
			<fieldset>
			<legend>Informations basique	</legend>
				{{ Form::label('loyer_min','Loyer MIN') }}

				{{ Form::select('loyer_min', array(
					'100'=>'100',
					'200'=>'200'
					));

				}}

				{{ Form::label('loyer_max','Loyer MAX') }}
				{{ Form::select('loyer_max',array(
					'100'=>'100',
					'200'=>'200'
					));

				}}



				{{ Form::label('charge','Charges') }}

				{{ Form::select('charge', array(
					'Comprise',
					'non-comprise'
					));

				}}
			</fieldset>
		</div> -->
		{{Form::submit('envoye')}}
		{{Form::close()}}
		<!-- test si la session ancienne recherche existe -->
		{{ $errors->first('url','<div class="error">:message</div>') }} 

	</div>
	<div id="detaillee">
		<p>{{link_to_route('showDetaillee','Détaillée')}}</p>
		<fieldset>

			<p>{{('Localiser : Une école, une ville, un kot')}}</p>

			{{ Form::open(array('detaillee' => 'recherche/detaillee' )) }}

			<fieldset>
				<legend>{{('Base')}}</legend>
				{{ Form::label('loyer_max','Loyer MAX') }}

				{{ Form::select('loyer_max', array(
					'200',
					'3OO'
					));

				}}
			</fieldset>

			<fieldset>
				<legend>{{('Supplémentaire')}}</legend>
				{{ Form::label('loyer_max','Loyer MAX') }}

				{{ Form::select('loyer_max', array(
					'200',
					'3OO'
					));

				}}
			</fieldset>

			<fieldset>
				<legend>{{('Bâtiment')}}</legend>
				{{ Form::label('loyer_max','Loyer MAX') }}

				{{ Form::select('loyer_max', array(
					'200',
					'3OO'
					));

				}}
			</fieldset>

			<fieldset>
				<legend>{{{('Carte')}}}</legend>
				{{ Form::label('loyer_max','Loyer MAX') }}

				{{ Form::select('loyer_max', array(
					'200',
					'3OO'
					));

				}}
			</fieldset>

			{{ Form::submit('Chercher') }}

			{{Form::close()}}

			{{ $errors->first('url','<div class="error">:message</div>') }} 


		</fieldset>
		@if(Auth::check())
		{{('Recherche enregistrée')}}
		{{Form::open(array('enregistre'=>'recherche/enregistrée'))}}

		{{Form::select('mesRecherches',array('toto','titi'))}}

		{{Form::submit('chercher')}}
		{{Form::close()}}
		@endif
	</div>
</div>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDHJ3p-sn1Y5tJGrzH9MF5cbR5sdsDmhfg&sensor=false&libraries=places,geometry"></script>
{{ HTML::script('js/map.js') }}


@stop