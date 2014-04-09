@extends('layout.layout')

@section('container')
@include('inscription.etapes')

@for($i = $date; $i < ($date +Config::get('var.mois')); $i++ )

{{Helpers::build_calendar($currentDate->month, $currentDate->year)}}

<?php $currentDate = $currentDate->addMonth();?>

@endfor
<div class="dispoPopup popup">
	<div class="content">
		{{Form::open(array('url'=>'ajax/addDispo','id'=>'addDispo'))}}
		
		{{Form::text('date_debut','',array('class'=>'date date_debut','placeholder'=>trans('form.date_debut')))}}

		{{Form::text('date_fin','',array('autofocus','class'=>'date date_fin','placeholder'=>trans('form.date_fin')))}}
		
		{{Form::submit(trans('form.button_valid'))}}

		{{Form::close()}}
	</div>
</div>
<div class="dispoUpdatePopup popup">
	<div class="content">
		{{Form::open(array('url'=>'ajax/updateDispo','id'=>'updateDispo'))}}
		
		{{Form::text('date_debut','',array('class'=>'date date_debut','placeholder'=>trans('form.date_debut')))}}

		{{Form::text('date_fin','',array('autofocus','class'=>'date date_fin','placeholder'=>trans('form.date_fin')))}}

		{{Form::hidden('tarif_id','',array('class'=>'tarif_id'))}}
		
		{{Form::submit(trans('form.button_valid'))}}

		{{Form::close()}}

		{{Form::open(array('url'=>'ajax/deleteDispo','id'=>'deleteDispo'))}}

		{{Form::hidden('tarif_id','',array('class'=>'tarif_id'))}}
		{{Form::submit('Supprimer')}}
		{{Form::close()}}
	</div>
</div>
{{link_to_route('etape6Index',trans('form.button_valid'),Auth::user()->slug)}}
<div class="overlay"></div>
@stop