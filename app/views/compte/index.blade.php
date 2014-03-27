@extends('layout.layout')

@section('container')



{{link_to_route('etape1Index','Ajout d\'une annonce',Auth::user()->slug)}}



liste d'annonces

@stop