@extends('layout.layout')

@section('container')



{{link_to_route('etape1Index','Ajout d\'une annonce',Auth::user()->slug)}}

@if(Helpers::isOk($nbInscriptionProprietePasFinie))

{{link_to_route('listLocationPropri',trans('compte.listLocation'),Auth::user()->slug)}}

@endif

liste d'annonces

@stop