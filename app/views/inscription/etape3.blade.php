@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(isset($success))
<span class="success">{{$success}}</span>
@endif
{{Form::open(array('route'=>'inscription'))}}

{{Form::label('pays',trans('form.enter_country'))}}
{{Form::select('pays',$paysList, '',array('class'=>'select paysAjax','data-placeholder'=>trans('form.enter_country')))}}
<br/>

{{Form::label('region',trans('form.enter_region'))}}
{{Form::select('region',$regionList, '',array('class'=>'select regionAjax','data-placeholder'=>trans('form.enter_region')))}}
<br/>

{{Form::label('sous_region',trans('form.enter_sousRegion'))}}
{{Form::select('sous_region',$sousRegionList, '',array('class'=>'select','data-placeholder'=>trans('form.enter_sousRegion')))}}
<br/>

{{Form::label('localite',trans('form.enter_localite'))}}
{{Form::select('localite',$localiteList, '',array('class'=>'select','data-placeholder'=>trans('form.enter_localite')))}}
<br/>

{{Form::close()}}

@stop