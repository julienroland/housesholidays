@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(isset($success))
<span class="success">{{$success}}</span>
@endif


{{Form::open(array('url'=>'ajax/uploadImage','files'=>true,'data-proprieteId'=>Session::get('proprieteId'),'data-userId'=>Auth::user()->id))}}
<div id="mulitplefileuploader">Upload</div>

{{Form::hidden('preview_image','',array('id'=>'preview_image'))}}

</form>

{{Form::open(array('url'=>'ajax/uploadImage','files'=>true,'data-proprieteId'=>Session::get('proprieteId'),'data-userId'=>Auth::user()->id,'id'=>'baseForm'))}}
{{Form::file('file', array('class'=>'baseFile'))}}
{{Form::submit('envoyer', array('class'=>'baseFile'))}}
{{Form::close()}}

@if(isset($photosPropriete->data) && Helpers::isOk( $photosPropriete->data))
<div id="images">
	<ul>
		@foreach( $photosPropriete->data as $photo)
		
		<li>
			<div class="image">

				<img src="{{'../../'.Config::get('var.upload_folder').'/'.Auth::user()->id.'/'.Config::get('var.propriete_folder').'/'.$photo->propriete_id.'/'.Helpers::replaceExtension( $photo->url, $photo->extension)}}" alt="{{$photo->alt}}">

			</div>
			<a href="" class="supprimerImage" data-id="{{$photo->id}}" title="Supprimer">Supprimer l'image</a>
		</li>
		@endforeach
	</ul>
</div>

@endif
{{link_to_route('etape4Index',trans('form.button_valid'),Auth::user()->slug)}}
@stop