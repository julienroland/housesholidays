@extends('layout.layout')

@section('container')

@if( isset($proprietes ) && Helpers::isOk( $proprietes ))

@foreach( $proprietes as $propriete )
{{dd($propriete)}}

@endforeach

@else

<p>Aucune inscription non-finie</p>

@endif

@stop