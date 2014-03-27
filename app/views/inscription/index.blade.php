@extends('layout.layout')

@section('container')
Les avantages, blabla bla

@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif


{{Form::open(array('route'=>'inscription'))}}
{{Form::label('prenom',trans('form.enter_firstname'))}}
{{Form::text('prenom',(isset(Session::get('input_1','')['prenom'])?Session::get('input_1','')['prenom']:''),array('placeholder'=>'John','required'))}}
<br/>
{{Form::label('nom',trans('form.enter_name'))}}
{{Form::text('nom',(isset(Session::get('input_1','')['nom'])?Session::get('input_1','')['nom']:''),array('placeholder'=>'Doe','required'))}}
<br/>
{{Form::label('email',trans('form.enter_email'))}}
{{Form::email('email',(isset(Session::get('input_1','')['email'])?Session::get('input_1','')['email']:''),array('placeholder'=>'email@email.com','required'))}}
<br/>
{{Form::label('pays_id',trans('form.enter_country'))}}
{{Form::select('pays',$paysList,(isset($paysList,Session::get('input_1','')['pays']) ? Session::get('input_1','')['pays']:''),array('class'=>'select','data-placeholder'=>trans('form.enter_country'),'required'))}}
<br/>
{{Form::label('password',trans('form.enter_password'))}}
{{Form::password('password',array('required'))}}
<br/>
{{Form::label('check_password',trans('form.enter_password_ag'))}}
{{Form::password('check_password',array('required'))}}
<br/>
{{Form::label('cgv',trans('form.enter_cgv'))}}
{{Form::checkbox('cgv',true,(isset(Session::get('input_1','')['cgv']))? Session::get('input_1','')['cgv']:'',array('required'))}}
<br/>
{{Form::submit(trans('form.button_valid'))}}
{{Form::close()}}
@stop