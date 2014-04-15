@extends('layout.layout')

@section('container')
<div id="login-proprietaire">
	<div id="titre-texte-login-proprietaire">Déposez votre annonce en quelques clics</div>
	<div id="texte-login-proprietaire">
		<table class="fontSmall" width="100%" border="0" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td width="539" height="400" align="left" valign="top" style="padding-right:15px">

						@if($post->count())
							{{$post->pageTraduction[0]->texte}}
						@endif
						</td>
						<td width="321" align="left" valign="top" style=" border-left:1px solid #CCCCCC; padding-left:15px">
							<div id="signup_int" style="display: block;">

								<div id="signup_int" style="display:block;">
									<div class="tileHeadGreen" style="line-height:1.6em;height:30px;font-size:16px;border:1px solid #555;border-radius:5px;" align="center">
										{{trans('form.enregistrez-vous')}}      
									</div>
									@if ($errors->any())
									<div id="error_message" class="fontError errors" style="font-weight:bold;">
										<ul>
											{{ implode('', $errors->all('<li class="error">:message</li>')) }}
										</ul>
									</div>
									@endif

									{{Form::open(array('route'=>'inscription'),array('id'=>'new_user_frm','class'=>'fontSmallGray','style'=>'margin:0px;'))}}
									<div class="field">
										{{Form::label('prenom',trans('form.firstname'))}}
										{{Form::text('prenom',(isset(Session::get('input_1','')['prenom'])?Session::get('input_1','')['prenom']:''),array('placeholder'=>'John','required'))}}
									</div>
									<div class="field">
										{{Form::label('nom',trans('form.name'))}}
										{{Form::text('nom',(isset(Session::get('input_1','')['nom'])?Session::get('input_1','')['nom']:''),array('placeholder'=>'Doe','required'))}}
									</div>
									<div class="field">
										{{Form::label('email',trans('form.mail'))}}
										{{Form::email('email',(isset(Session::get('input_1','')['email'])?Session::get('input_1','')['email']:''),array('placeholder'=>'email@email.com','required'))}}
									</div>
									<div class="field">
										{{Form::label('pays',trans('form.enter_country'))}}
										{{Form::select('pays',$paysList,(isset($paysList,Session::get('input_1','')['pays']) ? Session::get('input_1','')['pays']:''),array('class'=>'select','data-placeholder'=>trans('form.country'),'required'))}}
									</div>
									<div class="field">
										{{Form::label('password', trans('form.mdp'))}}
										{{Form::password('password',array('required','placeholder'=>trans('form.mdp')))}}
									</div>
									<div class="field">
										{{Form::label('check_password',trans('form.enter_password_ag'))}}
										{{Form::password('check_password',array('required'))}}
									</div>
									<div class="cgv">
										{{Form::label('cgv',trans('form.enter_cgv'))}}
										{{Form::checkbox('cgv',true,(isset(Session::get('input_1','')['cgv']))? Session::get('input_1','')['cgv']:'',array('required'))}}
									</div>
									<div class="field">
									{{Form::submit(trans('form.button_send'),array('class'=>'white button'))}}
										{{Form::close()}}
									</div>
									<div style="margin-top:10px;padding-top:15px; padding-bottom:15px; border-top:1px solid #CCCCCC; border-bottom:1px solid #CCCCCC"> 
										<span>{{trans('form.dejaCompte')}}</span> : <a href="#" id="click_login">Cliquez ici&nbsp;</a>
									</div>
									<div class="banner-add">
										<img src="{{Config::get('var.image_folder')}}banner-newad-fr.jpg" alt="">
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		@stop
