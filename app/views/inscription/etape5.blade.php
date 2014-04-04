@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(isset($success))
<span class="success">{{$success}}</span>
@endif

{{Form::open(array('url'=>'','id'=>'addTarif'))}}

{{Form::select('monnaie',$monnaies,'',array('class'=>'select'))}}
<br>
{{Form::text('nom_saison','',array('placeholder'=>trans('form.nom_saison')))}}

{{Form::text('debut','',array('class'=>'date','placeholder'=>trans('form.debut')))}}
{{Form::text('fin','',array('class'=>'date','placeholder'=>trans('form.fin')))}}
{{Form::select('min_nuit',$nuits,'',array('class'=>'select','data-placeholder'=>trans('form.duree_min')))}}

{{Form::input('number','nuit','',array('placeholder'=>trans('form.nuit')))}}
{{Form::input('number','semaine','',array('placeholder'=>trans('form.semaine')))}}
{{Form::input('number','mois','',array('placeholder'=>trans('form.mois')))}}

<br>
{{link_to('','Options avancées')}}
<br>

{{Form::label('arrive','Jour d\'arrivée')}}
{{Form::select('arrive',$jours->data,'',array('class'=>'select','data-placeholder'=>'Choissiez un jour'))}}

{{Form::label('weekend','Ajouter des tarifs Spécial Week-End ?')}}
{{Form::checkbox('weekend','true')}}

{{Form::label('prix_weeekend','Prix par nuit de')}}
{{Form::input('number','prix_weekend','',array('placeholder'=>'Entrez la valeur'))}}

{{Form::label('jour_weekend[5]','Vendredi')}}
{{Form::checkbox('jour_weekend[5]','true')}}

{{Form::label('jour_weekend[4]','Samedi')}}
{{Form::checkbox('jour_weekend[4]','true')}}

{{Form::label('jour_weekend[3]','Dimanche')}}
{{Form::checkbox('jour_weekend[3]','true')}}

{{Form::checkbox('duree_supp','true','',array('id'=>'duree_supp'))}}
{{Form::label('duree_supp','Ne PAS appliquer ces tarifs pour les séjours d’une durée supérieure à')}}
{{Form::select('nuit_max',$nuits,'',array('class'=>'select','data-placeholder'=>'combien de nuit'))}}

{{Form::submit(trans('form.ajouter'))}}
{{Form::close()}}


@stop