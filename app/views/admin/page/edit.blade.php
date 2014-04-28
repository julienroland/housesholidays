@extends('admin.layout.layout')

@section('container')
<div class="container">
	@if($page->count())
	<div class="row">

		
		<div class="col-lg-12 main">
			<h1 aria-level="1" role="heading" class="header">Modifier le contenu</h1>
		</div>
	</div>
	{{Form::open(array('method'=>'put','route'=>array('admin.pages.update',$page->id)))}}
	<div id="tabs" >
		<ul class="nav nav-tabs">
			@foreach(Config::get('var.langId') as $key => $value)
			<li><a href="#tabs-{{$key}}">{{$value}}</a></li>
			@endforeach
		</ul>
		@foreach(Config::get('var.langId') as $key => $value)
		<div id="tabs-{{$key}}">
			<div class="row">
				<div class="col-lg-9 main">
					<div class="alert alert-warning"><strong>Attention!</strong> Si ce n'est pas une page à proprement parlé (si c'est du contenu integré dans une autre page), Les champs: <b>titre</b>, <b>hyperliens</b> et <b>SEO</b> ne seront pas utilisé </div>
					<div class="form-group">
						{{Form::text('titre['.$key.']',isset($page->pageTraduction[0]->titre)? $page->pageTraduction[0]->titre:'',array('class'=>'form-control input-lg','placeholder'=>'Titre de l\'article'))}}
					</div>

					<div class="form-group ">
						@if(isset($page->pageTraduction[0]->slug) && Helpers::isOk($page->pageTraduction[0]->slug))

						<div class="alert-info hyperliens">
							{{$page->pageTraduction[0]->slug}}
						</div>

						@else

						<div class="alert-info hyperliens">

							{{'Aucun hyperlien n\'est génére pour cette article'}}


						</div>
						@endif

					</div>

					<div class="form-group">
						{{Form::textarea('texte['.$key.']',isset($page->pageTraduction[0]->texte)? $page->pageTraduction[0]->texte:'',array('class'=>'form-control'))}}
					</div>

				</div>
				<div class="col-lg-3 infosSupp">
					<div class="form-group">
						<span><span class="glyphicon glyphicon-file"></span><strong>Nom: </strong>{{isset($page->nom)? $page->nom:''}}</span>

					</div>

					@if(isset($page->statut) && $page->statut== 1)

					<div class="form-group has-success">
						{{Form::checkbox('statut','ok',isset($page->statut) && $page->statut== 1? true:false,array('id'=>'statut','class'=>'inputSuccess1'))}}


						{{Form::label('statut','Publier',array('class'=>'control-label'))}}
					</div>

					@else

					<div class="form-group has-error">

						{{Form::checkbox('statut','ok',isset($page->statut) && $page->statut== 1? true:false,array('class'=>'inputWarning1','id'=>'statut'))}}
						{{Form::label('statut','Publier',array('class'=>'control-label'))}}

					</div>
					@endif

					<div class="form-group">
						<p><span class="glyphicon glyphicon-calendar"></span> <strong>Crée le :</strong>{{$page->created_at->format('d M Y')}}</p>

					</div>
					<div class="form-group">

						<p><span class="glyphicon glyphicon-calendar"></span> <strong>Dernière modification: </strong>{{$page->updated_at->format('d M Y')}}</p>
					</div>

					<div class="form-group">
						{{Form::submit('Mettre à jour',array('class'=>'btn btn-info btn-md'))}} <a href="" class="text-danger"><small>Déplacer dans la corbeille</small></a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-9">
					<h2 aria-level="2" role="heading">SEO de la page</h2>
				</div>

			</div>
			<div class="row">

				<div class="col-lg-9">
					<div class="alert alert-warning"><strong>Attention!</strong> Si ce n'est pas une page à proprement parlé (si c'est du contenu integré dans une autre page), ne remplissez pas les informations ci-dessous</div>
					<div class="form-group">

						{{Form::label('seo_title['.$key.']','Titre de la page (title)',array('placeholder'=>'Le title est afficher sur les onglets'))}}
						{{Form::text('seo_title['.$key.']','',array('class'=>'form-control input-lg'))}}
						<span class="small">L'affichage du titre dans les moteurs de recherche est limité à 70 caractères</span>
					</div>

					<div class="form-group">

						{{Form::label('seo_description['.$key.']','Description')}}
						{{Form::text('seo_description['.$key.']','',array('class'=>'form-control input-lg'))}}
						<span class="small">La méta description est limitée à 156 caractères.</span>

					</div>

					<div class="form-group">

						{{Form::label('seo_motclef['.$key.']','Mots-clefs')}}
						{{Form::text('seo_motclef['.$key.']','',array('class'=>'form-control input-lg'))}}

					</div>

				</div>
			</div>
		</div>
		@endforeach
	</div>
	{{Form::close()}}

	@endif
</div>
</div>

@stop