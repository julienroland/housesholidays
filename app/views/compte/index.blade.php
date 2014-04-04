@extends('layout.layout')

@section('container')



{{link_to_route('etape1Index','Ajout d\'une annonce',Auth::user()->slug)}}

@if(Helpers::isOk($nbInscriptionProprietePasFinie))

{{link_to_route('listInscriptionPasFinie','Voir les annonces non finie',Auth::user()->slug)}}

@endif

liste d'annonces

@stop