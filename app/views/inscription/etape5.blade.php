@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(isset($success))
<span class="success">{{$success}}</span>
@endif

{{Form::open(array('url'=>'','id'=>'addTarif'))}}
{{Form::select('monnaie',$monnaies,'',array('class'=>'select'))}}
<br>
{{Form::text('nom_saison', isset(Session::get('input_5')['nom_saison']) && Helpers::isOk(Session::get('input_5')['nom_saison']) ? Session::get('input_5')['nom_saison'] : '',array('placeholder'=>trans('form.nom_saison'),'required'))}}

{{Form::text('debut', isset(Session::get('input_5')['debut']) ? Session::get('input_5')['debut'] : '',array('class'=>'date','placeholder'=>trans('form.debut'),'required'))}}
{{Form::text('fin', isset(Session::get('input_5')['fin'])  ? Session::get('input_5')['fin'] : '',array('class'=>'date','placeholder'=>trans('form.fin'),'required'))}}
{{Form::select('min_nuit',$nuits,isset(Session::get('input_5')['min_nuit']) ? Session::get('input_5')['min_nuit'] : '',array('class'=>'select','data-placeholder'=>trans('form.duree_min'),'required'))}}

{{Form::input('number','nuit',isset(Session::get('input_5')['nuit']) ? Session::get('input_5')['nuit'] : '',array('placeholder'=>trans('form.by_nuit'),'required'))}}

{{Form::input('number','semaine',isset(Session::get('input_5')['semaine']) ? Session::get('input_5')['semaine'] : '',array('placeholder'=>trans('form.semaine'),'required'))}}
{{Form::input('number','mois',isset(Session::get('input_5')['mois']) ? Session::get('input_5')['mois'] : '',array('placeholder'=>trans('form.mois'),'required'))}}

<br>
{{link_to('','Options avancées',array('class'=>'linkOpAvance'))}}


<div class="opAvance">

	{{Form::label('arrive','Jour d\'arrivée')}}
	{{Form::select('arrive',$jours->data,isset(Session::get('input_5')['arrive']) && Helpers::isOk(Session::has('input_5')['arrive']) ? Session::get('input_5')['arrive'] : '',array('class'=>'select','data-placeholder'=>'Choissiez un jour'))}}

	{{Form::label('weekend','Ajouter des tarifs Spécial Week-End ?')}}
	{{Form::checkbox('weekend','true',isset(Session::get('input_5')['weekend']) && Helpers::isOk(Session::get('input_5')['weekend']) ? true : false)}}

	{{Form::label('prix_weeekend','Prix par nuit de')}}
	{{Form::input('number','prix_weekend',isset(Session::get('input_5')['prix_weekend']) && Helpers::isOk(Session::get('input_5')['prix_weekend']) ? Session::get('input_5')['prix_weekend']: '' ,array('placeholder'=>'Entrez la valeur','id'=>'prix_weeekend'))}}

	{{Form::label('jour_weekend[5]','Vendredi')}}
	{{Form::checkbox('jour_weekend[5]','true',isset(Session::get('input_5')['jour_weekend'][5]) && Helpers::isOk(Session::get('input_5')['jour_weekend'][5]) ? true : false)}}

	{{Form::label('jour_weekend[6]','Samedi')}}
	{{Form::checkbox('jour_weekend[6]','true',isset(Session::get('input_5')['jour_weekend'][6]) && Helpers::isOk(Session::get('input_5')['jour_weekend'][6]) ? true : false)}}

	{{Form::label('jour_weekend[7]','Dimanche')}}
	{{Form::checkbox('jour_weekend[7]','true',isset(Session::get('input_5')['jour_weekend'][7]) && Helpers::isOk(Session::get('input_5')['jour_weekend'][7]) ? true : false)}}

	{{Form::checkbox('duree_supp','true',isset(Session::get('input_5')['duree_supp']) && Helpers::isOk(Session::get('input_5')['duree_supp']) ? true : false,array('id'=>'duree_supp'))}}
	{{Form::label('duree_supp','Ne PAS appliquer ces tarifs pour les séjours d’une durée supérieure à')}}

	{{Form::select('nuit_max',$nuits,isset(Session::get('input_5')['nuit_max']) && Helpers::isOk(Session::get('input_5')['nuit_max']) ? Session::get('input_5')['nuit_max'] : '',array('class'=>'select','data-placeholder'=>'combien de nuit'))}}
</div>
{{Form::hidden('proprieteId',isset($data) && is_object($data) ? $data->id : Session::get('proprieteId'))}}
{{Form::submit(trans('form.ajouter'))}}
{{Form::close()}}

{{Form::open(array('url'=>''))}}
@if(isset($tarifs) && Helpers::isOk($tarifs))
<table id="tarifTable">
	<thead>
		<tr>
			<td>{{trans('form.tarif_1')}}</td>
			<td>{{trans('form.tarif_2')}}</td>
			<td>{{trans('form.tarif_3')}}</td>
			<td>{{trans('form.tarif_4')}}</td>
			<td>{{trans('form.tarif_5')}}</td>
			<td>{{trans('form.tarif_6')}}</td>
			<td>{{trans('form.actions')}}</td>
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
		<td>@if(isset($tarif->prix_weekend) && Helpers::isOk($tarif->prix_weekend) && $tarif->prix_weekend!= 0)
		{{$tarif->prix_weekend}} {{$tarif->monnaie->icon}}@endif</td>
		<td>{{$tarif->prix_semaine}} {{$tarif->monnaie->icon}}</td>
		<td>{{$tarif->prix_mois}} {{$tarif->monnaie->icon}}</td>
		<td>{{$tarif->duree_min}} {{trans('form.nuit')}}</td>
		<td>{{link_to_route('updateTarif',trans('form.modifier'),array(),array('data-id'=>$tarif->id,'class'=>'updateTarif'))}} - {{link_to_route('deleteTarif',trans('form.supprimer'),array(),array('class'=>'deleteTarif','data-id'=>$tarif->id))}}</td>

	</tr>
	@endforeach
</table>
@endif
{{Form::close()}}
@if(Session::get('etape3') && Helpers::isOk(Session::get('proprieteId')) )

{{Form::open(array('method'=>'put','route'=>array('inscription_etape4_update', Auth::user()->slug, $propriete->id)))}}

@else

{{Form::open(array('route'=>array('inscription_etape4', Auth::user()->slug, $propriete->id)))}}

@endif

{{Form::label('nettoyage',trans('form.nettoyage'))}}
{{Form::input('number','nettoyage', isset($propriete->nettoyage) ? $propriete->nettoyage : (isset(Session::get('input_5bis')['nettoyage']) ? Session::get('input_5bis')['nettoyage'] :''))}}
<br>

{{Form::label('accompte',trans('form.acompte'))}}
{{Form::input('number','accompte',isset($propriete->caution) ? $propriete->caution : (isset(Session::get('input_5bis')['accompte']) ? Session::get('input_5bis')['accompte'] :''))}}
<br>
{{Form::label('conditions',trans('form.condition'))}}
{{Form::textarea('conditions',isset($propriete->condition_paiement) ? $propriete->condition_paiement : (isset(Session::get('input_5bis')['conditions']) ? Session::get('input_5bis')['conditions'] :''))}}

{{Form::submit(trans('form.button_valid'))}}
{{Form::close()}}

<div class="tarifUpdatePopup popup">
	{{Form::open(array('url'=>'','id'=>'updateTarif'))}}

	{{Form::select('monnaie',$monnaies,'',array('class'=>'select'))}}
	<br>
	{{Form::text('nom_saison','',array('placeholder'=>trans('form.nom_saison'),'required'))}}

	{{Form::text('debut','',array('class'=>'date','placeholder'=>trans('form.debut'),'required'))}}
	{{Form::text('fin','',array('class'=>'date','placeholder'=>trans('form.fin'),'required'))}}
	{{Form::select('min_nuit',$nuits,'',array('class'=>'select','data-placeholder'=>trans('form.duree_min'),'required'))}}

	{{Form::input('number','nuit','',array('placeholder'=>trans('form.by_nuit'),'required'))}}
	<span class="monnaie"></span>
	{{Form::input('number','semaine','',array('placeholder'=>trans('form.semaine'),'required'))}}
	<span class="monnaie"></span>
	{{Form::input('number','mois','',array('placeholder'=>trans('form.mois'),'required'))}}
	<span class="monnaie"></span>

	<br>
	{{link_to('','Options avancées',array('class'=>'linkOpAvance'))}}

	<div class="opAvance">
		<br>

		{{Form::label('arrive_popup','Jour d\'arrivée')}}
		{{Form::select('arrive_popup',$jours->data,'',array('class'=>'select','data-placeholder'=>'Choissiez un jour'))}}

		{{Form::label('weekend_popup','Ajouter des tarifs Spécial Week-End ?')}}
		{{Form::checkbox('weekend_popup','true')}}

		{{Form::label('prix_weekend_popup','Prix par nuit de')}}
		{{Form::input('number','prix_weekend_popup','' ,array('placeholder'=>'Entrez la valeur','id'=>'prix_weekend_popup'))}}

		{{Form::label('jour_weekend_popup[5]','Vendredi')}}
		{{Form::checkbox('jour_weekend_popup[5]','true')}}

		{{Form::label('jour_weekend_popup[6]','Samedi')}}
		{{Form::checkbox('jour_weekend_popup[6]','true')}}

		{{Form::label('jour_weekend_popup[7]','Dimanche')}}
		{{Form::checkbox('jour_weekend_popup[7]','true')}}

		{{Form::checkbox('duree_supp_popup','true','',array('id'=>'duree_supp_popup'))}}
		{{Form::label('duree_supp_popup','Ne PAS appliquer ces tarifs pour les séjours d’une durée supérieure à')}}

		{{Form::select('nuit_max_popup',$nuits,'',array('class'=>'select','data-placeholder'=>'combien de nuit'))}}
	</div>

	{{Form::hidden('tarifId','',array('class'=>'tarifId'))}}
	{{Form::hidden('weekendId','',array('class'=>'weekendId'))}}
	{{Form::submit(trans('form.modifier'))}}
	{{Form::close()}}

</div>
<div class="overlay"></div>
@stop