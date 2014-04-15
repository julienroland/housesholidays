@extends('layout.layout')

@section('container')
@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif

{{Form::open(array('route'=>'connexion'))}}
{{Form::label('email',trans('form.enter_email'))}}
{{Form::text('email',Cookie::get('rememberEmail')['email'] ? Cookie::get('rememberEmail')['email'] : '', array('autocomplete'=>'false','required',Helpers::isOk(Cookie::get('rememberEmail')['email'])?'':'autofocus'))}}
<br>

{{Form::label('password',trans('form.enter_password'))}}
{{Form::password('password', array('required', Helpers::isOk(Cookie::get('rememberEmail')['email'])?'autofocus':''))}}
<br>

{{Form::label('remember',trans('form.remember'))}}
{{Form::checkbox('remember','ok', Helpers::isOk(Cookie::get('rememberEmail')['remember']) ? true  : false)}}
<br>
{{Form::submit(trans('form.button_valid'))}}

{{Form::close()}}
@stop