@include('admin.layout.head')
<body>
	<div class="jumbotron ">
		<div class="container connexion">
			<h1>Connectez-vous !</h1>
			@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					{{ implode('', $errors->all('<li class="error">:message</li>')) }}
				</ul>
			</div>
			@endif
			{{Form::open(array('route'=>'connecter'))}}
			<fieldset>
				<div class="input-group input-group-lg">
					<span class="input-group-addon">@</span>
					{{Form::text('email',isset(Cookie::get('rememberEmail')['email']) ? Cookie::get('rememberEmail')['email'] :'' ,array('class'=>'form-control',isset(Cookie::get('rememberEmail')['email']) ? :'autofocus','required','placeholder'=>'E-mail'))}}
				</div>
				<div class="input-group input-group-lg">
					<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span>	</span>
					{{Form::password('password',array('class'=>'form-control','required','autofocus','placeholder'=>'Mot de passe'))}}
				</div>
				<div class="input-group">
					<span class="input-group-addon">
						{{Form::checkbox('remember','ok', Helpers::isOk(Cookie::get('rememberEmail')['remember']) ? true  : false,array('id'=>'remember'))}}
					</span>
					{{Form::label('remember','Se souvenir de moi')}}
				</div>

				
			</fieldset>
			{{Form::submit('Envoyer',array('class'=>'btn-info'))}}
		</div>
		{{Form::close()}}
	</div>

</body>
@include('admin.layout.bottom')