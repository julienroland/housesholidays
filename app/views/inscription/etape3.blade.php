@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(isset($success))
<span class="success">{{$success}}</span>
@endif
@if ($errors->any())
<div id="error_message" class="fontError errors" style="font-weight:bold;">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif
@if(Session::has('etape2') && Helpers::isOk(Session::get('proprieteId')))

{{Form::open(array('method'=>'put','route'=>array('inscription_etape2_update',Auth::user()->slug)))}}

@else 

{{Form::open(array('route'=>array('inscription_etape2',Auth::user()->slug)))}}

@endif

{{Form::label('pays',trans('form.enter_country'))}}
{{Form::select('pays',$paysList, Session::has('input_3') ? Session::get('input_3')['pays']: '',array('required','class'=>'select paysAjax','data-placeholder'=>trans('form.enter_country')))}}
<br/>

{{Form::label('region',trans('form.enter_region'))}}
{{Form::select('region',(Session::has('etape2') && Helpers::isOk(Session::get('proprieteId')) && isset($regionList)) ? $regionList :array(''), Session::has('input_3') ? Session::get('input_3')['region']: '',array('required','class'=>'select regionAjax','data-placeholder'=>trans('form.enter_region')))}}
<br/>

{{Form::label('sous_region',trans('form.enter_sousRegion'))}}
{{Form::select('sous_region',(Session::has('etape2') && Helpers::isOk(Session::get('proprieteId')) && isset($sousRegionList)) ? $sousRegionList :array(''), Session::has('input_3') ? Session::get('input_3')['sous_region']: '',array('required','class'=>'select','data-placeholder'=>trans('form.enter_sousRegion')))}}
<br/>

{{Form::label('localite',trans('form.enter_localite'))}}
{{Form::select('localite',$localiteList, Session::has('input_3') ? Session::get('input_3')['localite']: '',array('required','class'=>'select','data-placeholder'=>trans('form.enter_localite')))}}
<br/>

{{Form::label('adresse',trans('form.enter_adresse'))}}
{{Form::text('adresse',Session::has('input_3') ? Session::get('input_3')['adresse']: '',array('placeholder'=>trans('form.enter_adresse')))}}
<br/>

{{Form::label('situation',trans('form.enter_situation'))}}
{{Form::select('situation[]', $situationList, Session::has('input_3') ? Session::get('input_3')['situation']: '',array('class'=>'select','data-placeholder'=>trans('form.enter_situation'),'required','multiple'=>'true'))}}

{{Form::label('distance',trans('form.enter_distance'))}}
{{Form::text('distance',Session::has('input_3') ? Session::get('input_3')['distance']: '',array('required','placeholder'=>trans('form.enter_distance')))}}
<br/>
<button id="rechercheMap">Rechercher sur la carte</button>
<div id="gmap" style="width:100%;height:400px;"></div>

{{Form::hidden('latlng','',array('id'=>'latlng'))}}
{{Form::hidden('situationId', $situationId['id'])}}
{{Form::hidden('distanceId', $distanceId['id'])}}
{{Form::submit(trans('form.button_valid'))}}
{{Form::close()}}

@stop