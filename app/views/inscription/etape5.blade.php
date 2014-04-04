@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(isset($success))
<span class="success">{{$success}}</span>
@endif

{{Form::open(array('url'=>'','id'=>'addTarif'))}}

{{Form::select('monnaie',$monnaies,'',array('class'=>'select'))}}
<br>
{{Form::text('nom_saison', Helpers::isOk(Session::get('input_4')) ? Session::get('input_4')['nom_saison'] : '',array('placeholder'=>trans('form.nom_saison'),'required'))}}

{{Form::text('debut',Helpers::isOk(Session::has('input_4')) ? Session::get('input_4')['debut'] : '',array('class'=>'date','placeholder'=>trans('form.debut'),'required'))}}
{{Form::text('fin',Helpers::isOk(Session::has('input_4')) ? Session::get('input_4')['fin'] : '',array('class'=>'date','placeholder'=>trans('form.fin'),'required'))}}
{{Form::select('min_nuit',$nuits,Helpers::isOk(Session::has('input_4')) ? Session::get('input_4')['min_nuit'] : '',array('class'=>'select','data-placeholder'=>trans('form.duree_min'),'required'))}}

{{Form::input('number','nuit',Helpers::isOk(Session::has('input_4')) ? Session::get('input_4')['nuit'] : '',array('placeholder'=>trans('form.by_nuit'),'required'))}}
{{Form::input('number','semaine',Helpers::isOk(Session::has('input_4')) ? Session::get('input_4')['semaine'] : '',array('placeholder'=>trans('form.semaine'),'required'))}}
{{Form::input('number','mois',Helpers::isOk(Session::has('input_4')) ? Session::get('input_4')['mois'] : '',array('placeholder'=>trans('form.mois'),'required'))}}

<br>
{{link_to('','Options avancées')}}
<br>

{{Form::label('arrive','Jour d\'arrivée')}}
{{Form::select('arrive',$jours->data,Helpers::isOk(Session::has('input_4')) ? Session::get('input_4')['arrive'] : '',array('class'=>'select','data-placeholder'=>'Choissiez un jour'))}}

{{Form::label('weekend','Ajouter des tarifs Spécial Week-End ?')}}
{{Form::checkbox('weekend','true',Helpers::isOk(Session::get('input_4')['weekend']) ? true : false)}}

{{Form::label('prix_weeekend','Prix par nuit de')}}
{{Form::input('number','prix_weekend',Helpers::isOk(Session::get('input_4')['prix_weekend']) ? Session::get('input_4')['prix_weekend']: '' ,array('placeholder'=>'Entrez la valeur'))}}

{{Form::label('jour_weekend[5]','Vendredi')}}
{{Form::checkbox('jour_weekend[5]','true',Helpers::isOk(Session::get('input_4')['jour_weekend']['5']) ? true : false)}}

{{Form::label('jour_weekend[4]','Samedi')}}
{{Form::checkbox('jour_weekend[4]','true',Helpers::isOk(Session::get('input_4')['jour_weekend']['4']) ? true : false)}}

{{Form::label('jour_weekend[3]','Dimanche')}}
{{Form::checkbox('jour_weekend[3]','true',Helpers::isOk(Session::get('input_4')['jour_weekend']['3']) ? true : false)}}

{{Form::checkbox('duree_supp','true',Helpers::isOk(Session::get('input_4')['duree_supp']) ? true : false,array('id'=>'duree_supp'))}}
{{Form::label('duree_supp','Ne PAS appliquer ces tarifs pour les séjours d’une durée supérieure à')}}
{{Form::select('nuit_max',$nuits,Helpers::isOk(Session::get('input_4')['nuit_max']) ? Session::get('input_4')['nuit_max'] : '',array('class'=>'select','data-placeholder'=>'combien de nuit'))}}

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
		<td></td>
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