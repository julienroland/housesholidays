@extends('layout.layout')

@section('container')



{{link_to_route('checkSession','Ajout d\'une annonce',Auth::user()->slug)}}


{{link_to_route('listLocationPropri',trans('compte.listLocation'),Auth::user()->slug)}}

{{link_to_route('listCommentaires',trans('compte.listCommentaires'),Auth::user()->slug)}}

{{link_to_route('listMessages',trans('compte.listMessages'),Auth::user()->slug)}}

{{link_to(Lang::get('routes.deconnexion'),trans('form.logout'),array('id'=>'login-trigger'))}}

@stop

