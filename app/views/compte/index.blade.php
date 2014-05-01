@extends('layout.layout')

@section('container')



{{link_to_route('checkSession','Ajout d\'une annonce',Auth::user()->slug)}}


{{link_to_route('listLocationPropri',trans('compte.listLocation'),Auth::user()->slug)}}

{{link_to_route('listCommentaires',trans('compte.listCommentaires'),Auth::user()->slug)}}


@stop

