@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif

{{Form::open(array('route'=>'inscription_etape1'))}}
{{Form::label('prenom','Entrez votre prénom')}}
{{Form::text('prenom','',array('placeholder'=>'John'))}}
<br/>
{{Form::label('nom','Entrez votre nom')}}
{{Form::text('nom','',array('placeholder'=>'Doe'))}}
<br/>
{{Form::label('email','Entrez votre email')}}
{{Form::email('email','',array('placeholder'=>'email@email.com'))}}
<br/>
{{Form::label('pays','Choisissez votre pays')}}
{{Form::select('pays',$paysList,'')}}
<br/>
{{Form::label('region','Choisissez votre region')}}
{{Form::select('region',$regionList,'')}}
<br/>
{{Form::label('sous_region','Choisissez votre département/region')}}
{{Form::select('sous_region',array(''=>'Choisissez votre département/region','Namur'),'')}}
<br/>
{{Form::label('localité','Choisissez votre localité')}}
{{Form::select('localité',array(''=>'Choisissez votre localitée','Jambes'),'')}}
<br/>
{{Form::label('adresse','Entrez votre adresse')}}
{{Form::text('adresse','',array('placeholder'=>'42 Rue des vacances'))}}
<br/>
{{Form::label('postal','Entrez votre code postal')}}
{{Form::text('postal','',array('placeholder'=>'5100'))}}
<br/>

{{Form::label('maternelle','Choisissez votre langue maternelle')}}
{{Form::select('maternelle',array('','français'),'')}}
<br/>
{{Form::label('langue_parle','Choisissez les langues que vous parlez')}}
{{Form::select('langue_parle',array('','français'),'')}}
<br/>
{{Form::label('password','Entrez votre mot de passe')}}
{{Form::password('password','')}}
<br/>
{{Form::label('verif_password','Entrez votre mot de passe à nouveau')}}
{{Form::password('verif_password','')}}
<br/>
{{Form::label('cgv','Acceptez-vous les conditions général de vente')}}
{{Form::checkbox('cgv',true)}}
<br/>
{{Form::submit('valider')}}
{{Form::close()}}