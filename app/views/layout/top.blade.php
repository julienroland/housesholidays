<body id="{{isset($page) ? $page : ''}}">

<div id="container">
	<div id="menu">
		<div id="menu-content">

			<!-- Menu -->

			<ul id="menu-list">
				<li><a href="{{url('/')}}">{{trans('menu.accueil')}}</a></li>
				<li><a href="quisommesnous.php">{{trans('menu.apropos')}}</a></li>
				<li><a href="offres-speciales.php">{{trans('menu.offres')}}</a></li>
				@if(Auth::check())
				<li class="last"><a href="{{route('listFavoris', Auth::user()->slug)}}">{{trans('menu.favoris')}}</a></li>
				@endif
			</ul>

			<!-- Langs -->

			<div class="language-select">
				{{Form::select('lang',trans('general.lang'),'')}}
			</div>

			<!-- Reseaux -->

			<ul id="social">
				<li id="facebook"><a href="https://www.facebook.com/HousesHolidays" rel="nofollow">

					{{trans('head.facebook')}}

				</a></li>
				<li id="twitter"><a href="https://twitter.com/#!/housesholidays/" rel="nofollow">

					{{trans('head.twitter')}}

				</a></li>
			</ul>
			<!-- If login -->
			@if(Auth::check())

			<div id="nav-login">
				<ul>
					<li>
						{{link_to_route('compte', trans('menu.admin'),array(Auth::user()->slug))}}
					</li>
					<li> 
						
						{{link_to(Lang::get('routes.deconnexion'),trans('form.logout'),array('id'=>'login-trigger'))}}
					</li>
				</ul>
			</div>

			@else

			<div id="nav-login">
				<ul>
					<li id="login"> <a id="login-trigger" href="javascript:void(0)">
						{{trans('form.login')}}

						<span>▼</span> </a>
						<div id="login-content">

							{{Form::open(array('route'=>'connexion'))}}

							<fieldset id="inputs">

								{{Form::label('email',trans('form.enter_email'),array('style'=>'display:none;'))}}
								{{Form::text('email',Cookie::get('rememberEmail')['email'] ? Cookie::get('rememberEmail')['email'] : '', array(
									'id'=>'username_top',
									'placeholder'=> trans('form.mail'),
									'required',
									Helpers::isOk(Cookie::get('rememberEmail')['email'])?'':'autofocus'
									))}}

									{{Form::label('password',trans('form.enter_password'),array('style'=>'display:none;'))}}
									{{Form::password('password', array(
										'id'=>'username_top',
										'required',
										'placeholder'=>trans('form.mdp'),
										Helpers::isOk(Cookie::get('rememberEmail')['email'])?'autofocus':''
										))}}

									</fieldset>
	
									<fieldset id="actions">
										{{Form::checkbox('remember','ok', Helpers::isOk(Cookie::get('rememberEmail')['remember']) ? true  : false,array('id'=>'remember'))}}
										{{Form::label('remember',trans('form.remember'))}}
										
									</fieldset>
									<fieldset id="actions">
										{{Form::submit(trans('form.button_send'),array('id'=>'submit'))}}

									</fieldset>

									{{Form::close()}}
								</div>
							</li>
							<li id="signup"> 
								
								{{link_to(Lang::get('routes.inscription'),trans('form.inscription'))}}

							</li>
						</ul>
					</div>

					@endif

				</div>
			</div>
			<!--end menu-->
			<div id="content">
				<div id="header"> <a href="{{url('/')}}"><img id="logo" src="{{Config::get('var.image_folder')}}logo.png" width="336" height="74" alt="{{trans('general.logo_alt')}}" /></a>
				</div>
