@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(isset($success))
<span class="success">{{$success}}</span>
@endif
@if ($errors->any())
<div id="error_message" class="fontError errors" style="font-weight:bold;">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif
@if(Session::get('etape7') && Helpers::isOk($propriete) )

{{Form::open(array('method'=>'put','route'=>array('inscription_etape6_update',Auth::user()->slug, $propriete->id)))}}

@else

{{Form::open(array('route'=>array('inscription_etape6', Auth::user()->slug, $propriete->id)))}}

@endif

<div class="field">
	{{Form::label('prenom',trans('form.firstname'))}}
	{{Form::text('prenom',isset($user) && Helpers::isOk($user->prenom)? $user->prenom :(isset(Session::get('input_7','')['prenom'])?Session::get('input_7','')['prenom']:''),array('placeholder'=>'John','required'))}}
</div>
<div class="field">
	{{Form::label('nom',trans('form.name'))}}
	{{Form::text('nom',isset($user) && Helpers::isOk($user->nom)? $user->nom :(isset(Session::get('input_7','')['nom'])?Session::get('input_7','')['nom']:''),array('placeholder'=>'Doe','required'))}}
</div>
<div class="field">
	{{Form::label('email',trans('form.mail'))}}
	{{Form::email('email',isset($user) && Helpers::isOk($user->email)? $user->email :(isset(Session::get('input_7','')['email'])?Session::get('input_7','')['email']:''),array('placeholder'=>'email@email.com','required'))}}
</div>

<div class="field">
{{Form::label('site',trans('form.enter_site'))}}
{{Form::text('site',isset($user->site_web) ? $user->site_web :(Session::has('input_7') ? Session::get('input_7')['site']: ''),array('placeholder'=>trans('form.enter_site')))}}
</div>
<div class="field">
{{Form::label('contact',trans('form.enter_pContact'))}}
{{Form::text('contact',isset($user->personne_contact) ? $user->personne_contact :(Session::has('input_7') ? Session::get('input_7')['contact']: ''),array('placeholder'=>trans('form.enter_pContact')))}}
</div>
<div class="field">
	{{Form::label('pays',trans('form.enter_country'))}}
	{{Form::select('pays',$paysList,isset($user) && Helpers::isOk($user->pays_id)? $user->pays_id :(isset($paysList,Session::get('input_7','')['pays']) ? Session::get('input_7','')['pays']:''),array('class'=>'select','data-placeholder'=>trans('form.country'),'required'))}}
</div>

<div class="field">
	{{Form::label('region',trans('form.enter_region'))}}
	{{Form::select('region',isset($regionList) ? $regionList :array(''), isset($user->region_id) ? $user->region_id :(Session::has('input_7') && isset(Session::get('input_7')['region']) ? Session::get('input_7')['region']: '') ,array('class'=>'select','data-placeholder'=>trans('form.enter_region'),'required'))}}
</div>

<div class="field">
	{{Form::label('sous_region',trans('form.enter_sousRegion'))}}
	{{Form::select('sous_region',isset($sousRegionList)? $sousRegionList :array(''), isset($user->sous_region_id) ? $user->sous_region_id :(Session::has('input_7') ? Session::get('input_7')['sous_region']: '') ,array('class'=>'select','data-placeholder'=>trans('form.enter_sousRegion'),'required'))}}
</div>

{{Form::label('localite',trans('form.enter_localite'))}}
{{Form::select('localite',$localiteList, isset($user->localite_id) ? $user->localite_id :(Session::has('input_7') ? Session::get('input_7')['localite']: ''),array('class'=>'select','data-placeholder'=>trans('form.enter_localite'),'required'))}}
<br/>



{{Form::label('adresse',trans('form.enter_adresse'))}}
{{Form::text('adresse',isset($user->adresse) ? $user->adresse :(Session::has('input_7') ? Session::get('input_7')['adresse']: ''),array('placeholder'=>trans('form.enter_adresse'),'required'))}}
<br>

{{Form::label('postal',trans('form.enter_postal'))}}
{{Form::text('postal',isset($user->postal) ? $user->postal :(Session::has('input_7') ? Session::get('input_7')['postal']: ''),array('placeholder'=>trans('form.enter_postal'),'required'))}}

<br>
{{Form::label('maternelle',trans('form.enter_maternelle'))}}
{{Form::select('maternelle',Config::get('var.langId'),isset($user->maternelle_id) ? $user->maternelle_id :(Session::has('input_7') ? Session::get('input_7')['maternelle']: ''),array('placeholder'=>trans('form.enter_maternelle'),'required'))}}
<br>
{{Form::label('tel1',trans('form.enter_tel',array('num'=> 1)))}}
{{Form::text('tel1',isset($tel1->numero) ? $tel1->numero :(Session::has('input_7') ? Session::get('input_7')['tel1']: ''),array('placeholder'=>trans('form.enter_tel'),'required'))}}

{{Form::label('heure1',trans('form.enter_heure'))}}
{{Form::text('heure1',isset($tel1->heure) ? $tel1->heure :(Session::has('input_7') ? Session::get('input_7')['heure1']: ''),array('placeholder'=>trans('form.enter_heure')))}}

<br>
{{Form::label('tel2',trans('form.enter_tel',array('num'=> 2)))}}
{{Form::text('tel2',isset($tel2->numero) ? $tel2->numero :(Session::has('input_7') ? Session::get('input_7')['tel2']: ''),array('placeholder'=>trans('form.enter_tel')))}}

{{Form::label('heure2',trans('form.enter_heure'))}}
{{Form::text('heure2',isset($tel2->heure) ? $tel2->heure :(Session::has('input_7') ? Session::get('input_7')['heure2']: ''),array('placeholder'=>trans('form.enter_heure')))}}
<br>

{{Form::label('fax',trans('form.enter_fax'))}}
{{Form::text('fax',isset($user->fax) ? $user->fax :(Session::has('input_7') ? Session::get('input_7')['fax']: ''),array('placeholder'=>trans('form.enter_fax')))}}
<br>
{{Form::label('autre',trans('form.autre_lang'))}}
@foreach(Config::get('var.langId') as $key => $lang)

{{Form::label('autre['.$key.']', $lang)}}
{{Form::checkbox('autre['.$key.']','true',  isset($langue[$key]) && Helpers::isOk($langue[$key]) ? true : (Session::has('input_7') && isset(Session::get('input_7')['autre'][$key]) ? true: false))}}

@endforeach
<br>
{{Form::submit(trans('form.button_valid'))}}
{{Form::close()}}
@stop