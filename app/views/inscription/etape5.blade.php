@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(isset($success))
<span class="success">{{$success}}</span>
@endif

{{Form::open(array('url'=>'','id'=>'addTarif'))}}

{{Form::select('monnaie',$monnaies,'',array('class'=>'select'))}}
<br>
{{Form::text('nom_saison', isset(Session::get('input_4')['nom_saison']) && Helpers::isOk(Session::get('input_4')['nom_saison']) ? Session::get('input_4')['nom_saison'] : '',array('placeholder'=>trans('form.nom_saison'),'required'))}}

{{Form::text('debut', isset(Session::get('input_4')['debut']) ? Session::get('input_4')['debut'] : '',array('class'=>'date','placeholder'=>trans('form.debut'),'required'))}}
{{Form::text('fin', isset(Session::get('input_4')['fin'])  ? Session::get('input_4')['fin'] : '',array('class'=>'date','placeholder'=>trans('form.fin'),'required'))}}
{{Form::select('min_nuit',$nuits,isset(Session::get('input_4')['min_nuit']) ? Session::get('input_4')['min_nuit'] : '',array('class'=>'select','data-placeholder'=>trans('form.duree_min'),'required'))}}

{{Form::input('number','nuit',isset(Session::get('input_4')['nuit']) ? Session::get('input_4')['nuit'] : '',array('placeholder'=>trans('form.by_nuit'),'required'))}}
{{Form::input('number','semaine',isset(Session::get('input_4')['semaine']) ? Session::get('input_4')['semaine'] : '',array('placeholder'=>trans('form.semaine'),'required'))}}
{{Form::input('number','mois',isset(Session::get('input_4')['mois']) ? Session::get('input_4')['mois'] : '',array('placeholder'=>trans('form.mois'),'required'))}}

<br>
{{link_to('','Options avancées')}}
<br>

{{Form::label('arrive','Jour d\'arrivée')}}
{{Form::select('arrive',$jours->data,isset(Session::get('input_4')['arrive']) && Helpers::isOk(Session::has('input_4')['arrive']) ? Session::get('input_4')['arrive'] : '',array('class'=>'select','data-placeholder'=>'Choissiez un jour'))}}

{{Form::label('weekend','Ajouter des tarifs Spécial Week-End ?')}}
{{Form::checkbox('weekend','true',isset(Session::get('input_4')['weekend']) && Helpers::isOk(Session::get('input_4')['weekend']) ? true : false)}}

{{Form::label('prix_weeekend','Prix par nuit de')}}
{{Form::input('number','prix_weekend',isset(Session::get('input_4')['prix_weekend']) && Helpers::isOk(Session::get('input_4')['prix_weekend']) ? Session::get('input_4')['prix_weekend']: '' ,array('placeholder'=>'Entrez la valeur'))}}

{{Form::label('jour_weekend[5]','Vendredi')}}
{{Form::checkbox('jour_weekend[5]','true',isset(Session::get('input_4')['jour_weekend'][5]) && Helpers::isOk(Session::get('input_4')['jour_weekend'][5]) ? true : false)}}

{{Form::label('jour_weekend[6]','Samedi')}}
{{Form::checkbox('jour_weekend[6]','true',isset(Session::get('input_4')['jour_weekend'][6]) && Helpers::isOk(Session::get('input_4')['jour_weekend'][6]) ? true : false)}}

{{Form::label('jour_weekend[7]','Dimanche')}}
{{Form::checkbox('jour_weekend[7]','true',isset(Session::get('input_4')['jour_weekend'][7]) && Helpers::isOk(Session::get('input_4')['jour_weekend'][7]) ? true : false)}}

{{Form::checkbox('duree_supp','true',isset(Session::get('input_4')['duree_supp']) && Helpers::isOk(Session::get('input_4')['duree_supp']) ? true : false,array('id'=>'duree_supp'))}}
{{Form::label('duree_supp','Ne PAS appliquer ces tarifs pour les séjours d’une durée supérieure à')}}

{{Form::select('nuit_max',$nuits,isset(Session::get('input_4')['nuit_max']) && Helpers::isOk(Session::get('input_4')['nuit_max']) ? Session::get('input_4')['nuit_max'] : '',array('class'=>'select','data-placeholder'=>'combien de nuit'))}}

{{Form::submit(trans('form.ajouter'))}}
{{Form::close()}}

{{Form::open(array('url'=>''))}}

<table id="tarifTable">
	<thead>
		<tr>
			<td>{{trans('form.tarif_1')}}</td>
			<td>{{trans('form.tarif_2')}}</td>
			<td>{{trans('form.tarif_3')}}</td>
			<td>{{trans('form.tarif_4')}}</td>
			<td>{{trans('form.tarif_5')}}</td>
			<td>{{trans('form.tarif_6')}}</td>
		</tr>
	</thead>
	@foreach( $tarifs as $tarif )

	<tr>
		<td>
			<div class="saison">{{$tarif->saison}}</div>
			<div class="dates">
				<span class="debut">{{Helpers::toEuShortDate($tarif->date_debut)}}</span>
				<span class="fin">{{Helpers::toEuShortDate($tarif->date_fin)}}</span>
			</div>
		</td>
		<td>{{$tarif->prix_nuit}} {{$tarif->monnaie->icon}}</td>
		<td>@if(isset($tarif->prix_weekend) && Helpers::isOk($tarif->prix_weekend)){{$tarif->prix_weekend}} {{$tarif->monnaie->icon}}@endif</td>
		<td>{{$tarif->prix_semaine}} {{$tarif->monnaie->icon}}</td>
		<td>{{$tarif->prix_mois}} {{$tarif->monnaie->icon}}</td>
		<td>{{$tarif->duree_min}} {{trans('form.nuit')}}</td>
		
	</tr>
	@endforeach
</table>
{{Form::close()}}
{{Form::open(array('route'=>array('inscription_etape4',Auth::user()->slug)))}}

{{Form::label('nettoyage',trans('form.nettoyage'))}}
{{Form::input('number','nettoyage','')}}
<br>

{{Form::label('accompte',trans('form.acompte'))}}
{{Form::input('number','accompte','')}}
<br>
{{Form::label('conditions',trans('form.condition'))}}
{{Form::textarea('conditions')}}

{{Form::submit(trans('form.button_valid'))}}
{{Form::close()}}

@stop