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
{{Form::text('prenom','',array('placeholder'=>'John'))}}
<br/>
{{Form::label('nom',trans('form.enter_name'))}}
{{Form::text('nom','',array('placeholder'=>'Doe'))}}
<br/>
{{Form::label('email',trans('form.enter_email'))}}
{{Form::email('email','',array('placeholder'=>'email@email.com'))}}
<br/>
{{Form::label('pays_id',trans('form.enter_country'))}}
{{Form::select('pays',$paysList,'')}}
<br/>
{{Form::label('password',trans('form.enter_password'))}}
{{Form::password('password','')}}
<br/>
{{Form::label('check_password',trans('form.enter_password_ag'))}}
{{Form::password('check_password','')}}
<br/>
{{Form::label('cgv',trans('form.enter_cgv'))}}
{{Form::checkbox('cgv',true)}}
<br/>
{{Form::submit(trans('form.button_valid'))}}
{{Form::close()}}