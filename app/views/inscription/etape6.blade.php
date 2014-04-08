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
<div class="overlay"></div>
@stop