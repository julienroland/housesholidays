@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif

{{Form::open(array('url'=>'inscription'))}}
{{Form::label('prenom','Entrez votre prénom')}}
{{Form::text('prenom','',array('placeholder'=>'John'))}}
<br/>
{{Form::label('nom','Entrez votre nom')}}
{{Form::text('nom','',array('placeholder'=>'Doe'))}}
<br/>
{{Form::label('email','Entrez votre email')}}
{{Form::email('email','',array('placeholder'=>'email@email.com'))}}
<br/>
{{Form::label('pays','Entrez votre email')}}
{{Form::select('pays',array('belgique'),'')}}
<br/>
{{Form::label('mot_de_passe','Entrez votre mot de passe')}}
{{Form::password('mot_de_passe','')}}
<br/>
{{Form::label('verification_mot_de_passe','Entrez votre mot de passe à nouveau')}}
{{Form::password('verification_mot_de_passe','')}}
<br/>
{{Form::label('condition_general_de_vente','Acceptez-vous les conditions général de vente')}}
{{Form::checkbox('condition_general_de_vente',true)}}
<br/>
{{Form::submit('valider')}}
{{Form::close()}}