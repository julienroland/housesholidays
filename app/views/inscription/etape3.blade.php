@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(isset($success))
<span class="success">{{$success}}</span>
@endif

{{Form::open(array('route'=>array('inscription_etape2',Auth::user()->slug)))}}

{{Form::label('pays',trans('form.enter_country'))}}
{{Form::select('pays',$paysList, Session::has('input_3') ? Session::get('input_3')['pays']: '',array('class'=>'select paysAjax','data-placeholder'=>trans('form.enter_country')))}}
<br/>

{{Form::label('region',trans('form.enter_region'))}}
{{Form::select('region',$regionList, Session::has('input_3') ? Session::get('input_3')['region']: '',array('class'=>'select regionAjax','data-placeholder'=>trans('form.enter_region')))}}
<br/>

{{Form::label('sous_region',trans('form.enter_sousRegion'))}}
{{Form::select('sous_region',$sousRegionList, Session::has('input_3') ? Session::get('input_3')['sous_region']: '',array('class'=>'select','data-placeholder'=>trans('form.enter_sousRegion')))}}
<br/>

{{Form::label('localite',trans('form.enter_localite'))}}
{{Form::select('localite',$localiteList, Session::has('input_3') ? Session::get('input_3')['localite']: '',array('class'=>'select','data-placeholder'=>trans('form.enter_localite')))}}
<br/>

{{Form::label('adresse',trans('form.enter_adresse'))}}
{{Form::text('adresse',Session::has('input_3') ? Session::get('input_3')['adresse']: '',array('placeholder'=>trans('form.enter_adresse')))}}
<br/>

{{Form::label('situation',trans('form.enter_situation'))}}
{{Form::select('situation', $situationList,Session::has('input_3') ? Session::get('input_3')['situation']: '',array('class'=>'select','data-placeholder'=>trans('form.enter_situation')))}}

{{Form::label('distance',trans('form.enter_distance'))}}
{{Form::text('distance',Session::has('input_3') ? Session::get('input_3')['distance']: '',array('placeholder'=>trans('form.enter_distance')))}}
<br/>
<div id="gmap" style="width:100%;height:400px;"></div>

{{Form::hidden('latlng','',array('id'=>'latlng'))}}
{{Form::submit(trans('form.button_valid'))}}
{{Form::close()}}

@stop