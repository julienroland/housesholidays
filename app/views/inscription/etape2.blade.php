@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(Session::has('success'))
<div class="success">
	<ul>
		<li>{{Session::get('success')}}</li>
	</ul>
</div>
@endif
@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif
@if(isset($errorMessages))
<div class="error">
	@foreach($errorMessages->all() as $message)
	<span>{{$message}}</span>
	@endforeach
</div>
@endif

@if(Session::get('etape2') && Session::has('proprieteId') )

{{Form::open(array('method'=>'put','route'=>array('inscription_etape1_update',Auth::user()->slug,Session::get('proprieteId'))))}}

@elseif( isset($data) && is_object($data) && Helpers::isOk( $data ) && !Session::has('proprieteId'))

{{Form::open(array('method'=>'put','route'=>array('storePropriete1',$data->id)))}}

@else

{{Form::open(array('route'=>array('inscription_etape1',Auth::user()->slug)))}}

@endif

{{Form::label('nom_propriete',trans('form.enter_batiment_name'))}}
{{Form::text('nom_propriete', isset($data->nom) && Helpers::isOk($data->nom) ? $data->nom : (Session::has('input_2') ? Session::get('input_2')['nom_propriete']: '') ,array('placeholder'=>'Avana Mostra','required'))}}
<br/>

{{Form::label('titre_propriete',trans('form.enter_annonce_name'))}}
<div class="tabs">
	<ul>
		<li><a href="#fragment-1">FR</a></li>
		<li><a href="#fragment-2">EN</a></li>
		<li><a href="#fragment-3">NL</a></li>
		<li><a href="#fragment-4">DE</a></li>
		<li><a href="#fragment-5">ES</a></li>
	</ul>
	<div id="fragment-1">
		<span>{{trans('general.lang.fr')}}</span>
		{{Form::text('titre_propriete[1]', isset($titre->data) ? $titre->data[1] : (Session::has('input_2') && isset(Session::get('input_2')['titre_propriete']) ? Session::get('input_2')['titre_propriete'][1]: '') ,array('placeholder'=>trans('form.enter_annonce_placeholder')))}}
	</div>
	<div id="fragment-2">
		<span>{{trans('general.lang.en')}}</span>
		{{Form::text('titre_propriete[2]',isset($titre->data) ? $titre->data[2] : ( Session::has('input_2')  && isset(Session::get('input_2')['titre_propriete']) ? Session::get('input_2')['titre_propriete'][2]: '') ,array('placeholder'=>trans('form.enter_annonce_placeholder')))}}
	</div>
	<div id="fragment-3">
		<span>{{trans('general.lang.nl')}}</span>
		{{Form::text('titre_propriete[3]',isset($titre->data) ? $titre->data[3] : ( Session::has('input_2')  && isset(Session::get('input_2')['titre_propriete']) ? Session::get('input_2')['titre_propriete'][3]: '') ,array('placeholder'=>trans('form.enter_annonce_placeholder')))}}
	</div> 
	<div id="fragment-4">
		<span>{{trans('general.lang.de')}}</span>
		{{Form::text('titre_propriete[4]', isset($titre->data) ? $titre->data[4] : (Session::has('input_2')  && isset(Session::get('input_2')['titre_propriete']) ? Session::get('input_2')['titre_propriete'][4]: '') ,array('placeholder'=>trans('form.enter_annonce_placeholder')))}}
	</div> 
	<div id="fragment-5">
		<span>{{trans('general.lang.es')}}</span>
		{{Form::text('titre_propriete[5]',isset($titre->data) ? $titre->data[5] : ( Session::has('input_2')  && isset(Session::get('input_2')['titre_propriete']) ? Session::get('input_2')['titre_propriete'][5]: '') ,array('placeholder'=>trans('form.enter_annonce_placeholder')))}}
	</div>
</div>
<br/>

{{Form::label('type_propriete',trans('form.enter_batiement_type'))}}
{{Form::select('type_propriete',$typeBatimentList,isset($data->type_batiment_id) && Helpers::isOk($data->type_batiment_id) ? $data->type_batiment_id : ( Session::has('input_2') ? Session::get('input_2')['type_propriete']: ''),array('class'=>'select','required'))}}

<br/>
{{Form::label('nb_personne',trans('form.enter_nb_personne'))}}
{{Form::input('number','nb_personne',isset($data->nb_personne) && Helpers::isOk($data->nb_personne) ? $data->nb_personne : (Session::has('input_2') ? Session::get('input_2')['nb_personne']: ''),array('min'=>'1','max'=>'20','required'))}}
<br/>
{{Form::label('nb_chambre',trans('form.enter_nb_chambre'))}}
{{Form::input('number','nb_chambre',isset($data->nb_chambre) && Helpers::isOk($data->nb_chambre) ? $data->nb_chambre : (Session::has('input_2') ? Session::get('input_2')['nb_chambre']: ''),array('min'=>'1','max'=>'20','required'))}}
<br/>
{{Form::label('nb_sdb',trans('form.enter_nb_sdb'))}}
{{Form::input('number','nb_sdb',isset($data->nb_sdb) && Helpers::isOk($data->nb_sdb) ? $data->nb_sdb :( Session::has('input_2') ? Session::get('input_2')['nb_sdb']: ''),array('min'=>'0','max'=>'20'))}}
<br/>
{{Form::label('etage',trans('form.enter_etage'))}}
{{Form::input('number','etage',isset($data->etage) && Helpers::isOk($data->etage) ? $data->etage : (Session::has('input_2') ? Session::get('input_2')['etage']: ''),array('min'=>'0','max'=> 10,'required'))}}

<br/>
{{Form::label('taille_interieur',trans('form.enter_int_size'))}}
{{Form::text('taille_interieur', isset($data->taille_bien) && Helpers::isOk($data->taille_bien) ? $data->taille_bien : (Session::has('input_2') ? Session::get('input_2')['taille_interieur']: ''),array('placeholder'=>'2','required'))}}
<span>m²</span>
<br/>
{{Form::label('taille_exterieur',trans('form.enter_ext_size'))}}
{{Form::text('taille_exterieur',isset($data->taille_terrain) && Helpers::isOk($data->taille_terrain) ? $data->taille_terrain : (Session::has('input_2') ? Session::get('input_2')['taille_exterieur']: ''),array('placeholder'=>'2'))}}
<span>m²</span>
<br/>
{{Form::label('exposition',trans('form.exposition'))}}
{{Form::select('exposition',trans('form.expositionList'),isset($data->exposition_id) && Helpers::isOk($data->exposition_id) ? $data->exposition_id : ( Session::has('input_2') ? Session::get('input_2')['exposition']: ''))}}
{{Form::label('description',trans('form.enter_description'),array('required'))}}
<div class="tabs">
	<ul>
		<li><a href="#fragment-1">FR</a></li>
		<li><a href="#fragment-2">EN</a></li>
		<li><a href="#fragment-3">NL</a></li>
		<li><a href="#fragment-4">DE</a></li>
		<li><a href="#fragment-5">ES</a></li>
	</ul>
	<div id="fragment-1">
		<span>{{trans('general.lang.fr')}}</span>
		{{Form::textarea('description[1]',isset($description->data) ? $description->data[1] : (Session::has('input_2') && isset(Session::get('input_2')['description']) ? Session::get('input_2')['description'][1]: ''))}}
	</div>
	<div id="fragment-2">
		<span>{{trans('general.lang.en')}}</span>
		{{Form::textarea('description[2]',isset($description->data) ? $description->data[2] : (Session::has('input_2') && isset(Session::get('input_2')['description']) ? Session::get('input_2')['description'][2]: ''))}}
	</div>
	<div id="fragment-3">
		<span>{{trans('general.lang.nl')}}</span>
		{{Form::textarea('description[3]',isset($description->data) ? $description->data[3] : (Session::has('input_2') && isset(Session::get('input_2')['description']) ? Session::get('input_2')['description'][3]: ''))}}
	</div> 
	<div id="fragment-4">
		<span>{{trans('general.lang.de')}}</span>
		{{Form::textarea('description[4]',isset($description->data) ? $description->data[4] : (Session::has('input_2') && isset(Session::get('input_2')['description']) ? Session::get('input_2')['description'][4]: ''))}}
	</div> 
	<div id="fragment-5">
		<span>{{trans('general.lang.es')}}</span>
		{{Form::textarea('description[5]',isset($description->data) ? $description->data[5] : (Session::has('input_2') && isset(Session::get('input_2')['description']) ? Session::get('input_2')['description'][5]: ''))}}
	</div>
</div>

<h2 aria-level="2" role="heading">{{trans('form.title_lit')}}</h2>


@foreach( $listOption->literie as $key => $literie )
{{Form::label('literie_'.$literie->id,$literie->valeur)}}

@if(isset($options) && isset($options->data[$literie->id]))

{{Form::input('number','literie['.$literie->id.']', isset($options->data[$literie->id]) ? $options->data[$literie->id] : (Session::has('input_2') && Session::get('input_2')['literie'][$literie->id] ? Session::get('input_2')['literie'][$literie->id]: ''), array('min'=> 0, 'max'=> 20))}}

@else

{{Form::input('number','literie['.$literie->id.']', Session::has('input_2') && Session::get('input_2')['literie'][$literie->id] ? Session::get('input_2')['literie'][$literie->id]: '', array('min'=> 0, 'max'=> 20))}}

@endif
<br/>

@endforeach
<div class="interieur">
	<h2 aria-level="2" role="heading">{{trans('form.title_interieur')}}</h2>

	@foreach( $listOption->interieur as $key => $interieur )

	{{Form::label('interieur_'.$interieur->id,$interieur->valeur)}}

	@if(isset($options) && isset($options->data[$interieur->id]))

	@if($interieur->id == '35' || $interieur->id == '36' || $interieur->id == '37')
	
	<div class="group">

		@endif
		{{Form::checkbox('interieur['.$interieur->id.']','', isset($options->data[$interieur->id]) ? true : (Session::has('input_2') && isset(Session::get('input_2')['interieur'][$interieur->id]) ? Session::get('input_2')['interieur'][$interieur->id]: ''),array('id'=>'interieur_'.$interieur->id))}}

		@if($interieur->id == '35' || $interieur->id == '36' || $interieur->id == '37')

		{{Form::input('number','interieur['.$interieur->id.']','',array('class'=>'valeur','style'=>'display:block;','placeholder'=>trans('form.enter_number_of',array('nom'=>$interieur->valeur)),'style'=>'display:none;'))}}
	</div>
	@endif
	@else
	
	@if($interieur->id == '35' || $interieur->id == '36' || $interieur->id == '37')
	<div class="group">
		@endif
		{{Form::checkbox('interieur['.$interieur->id.']','',Session::has('input_2') && isset(Session::get('input_2')['interieur'][$interieur->id]) ? Session::get('input_2')['interieur'][$interieur->id]: '',array('id'=>'interieur_'.$interieur->id))}}

		@if($interieur->id == '35' || $interieur->id == '36' || $interieur->id == '37')

		{{Form::input('number','interieur['.$interieur->id.']','',array('class'=>'valeur','placeholder'=>trans('form.enter_number_of',array('nom'=>$interieur->valeur)),'style'=>'display:none;'))}}
	</div>
	@endif
	@endif

	@endforeach

</div>
<h2 aria-level="2" role="heading">{{trans('form.title_exterieur')}}</h2>

@foreach( $listOption->exterieur as $key => $exterieur )

{{Form::label('exterieur_'.$exterieur->id,$exterieur->valeur)}}

@if(isset($options) && isset($options->data[$exterieur->id]))

{{Form::checkbox('exterieur['.$exterieur->id.']','true',isset($options->data[$exterieur->id]) ? true : ( Session::has('input_2') && isset(Session::get('input_2')['exterieur'][$exterieur->id]) ? Session::get('input_2')['exterieur'][$exterieur->id]: ''), array('id'=>'exterieur_'.$exterieur->id))}}

@else

{{Form::checkbox('exterieur['.$exterieur->id.']','true',Session::has('input_2') && isset(Session::get('input_2')['exterieur'][$exterieur->id]) ? Session::get('input_2')['exterieur'][$exterieur->id]: '', array('id'=>'exterieur_'.$exterieur->id))}}


@endif

@endforeach
<br/>

{{Form::submit(trans('form.button_valid'))}}
{{Form::close()}}
@stop