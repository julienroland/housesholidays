@extends('layout.layout')

@section('container')
@include('inscription.etapes')
@if(isset($success))
<span class="success">{{$success}}</span>
@endif
<p>{{('max 15 images')}}</p>
<p>{{('Le premier element serra l image d\'accroche')}}</p>
{{Form::open(array('url'=>'ajax/uploadImage','files'=>true,'data-proprieteId'=> (isset($data) && is_object($data)) ? $data->id :(Session::get('proprieteId')),'data-userId'=>Auth::user()->id))}}
<div id="mulitplefileuploader">Upload</div>

{{Form::hidden('preview_image','',array('id'=>'preview_image'))}}

</form>

{{Form::open(array('url'=>'ajax/uploadImage','files'=>true, 'class'=>'upload', 'data-proprieteId'=>Session::get('proprieteId'), 'data-userId'=>Auth::user()->id,'id'=>'baseForm'))}}
{{Form::file('file', array('class'=>'baseFile'))}}
{{Form::submit('envoyer', array('class'=>'baseFile'))}}
{{Form::close()}}

@if(Session::get('etape3') && Helpers::isOk($propriete) )

{{Form::open(array('method'=>'put','route'=>array('inscription_etape3_update',Auth::user()->slug, $propriete->id)))}}


@else

{{Form::open(array('route'=>array('inscription_etape3',Auth::user()->slug, $propriete->id)))}}


@endif

@if(isset($photosPropriete->data) && Helpers::isOk( $photosPropriete->data))
<div id="images" >
	<ul id="sortable">
		@foreach( $photosPropriete->data as $photo)

		<li >
			<div class="image">

				<img src="{{'/'.Config::get('var.upload_folder').Auth::user()->id.'/'.Config::get('var.propriete_folder').'/'.$photo->propriete_id.'/'.Helpers::replaceExtension( $photo->url, $photo->extension)}}" alt="{{$photo->alt}}">

			</div>
			<a href="" class="supprimerImage" data-id="{{$photo->id}}" data-proprieteId="{{isset($propriete) && is_object($propriete) ? $propriete->id: Session::get('proprieteId')}}" title="Supprimer">Supprimer l'image</a>
		</li>
		@endforeach
	</ul>
</div>

@endif
{{Form::label('video',trans('form.video'))}}
{{Form::text('video',isset($propriete->video) ? $propriete->video : (isset(Session::get('input_4')['video']) && Helpers::isOk( Session::get('input_4')['video'] ) ? Session::get('input_4')['video'] : '') ,array('placeholder'=>trans('form.video')))}}

{{Form::hidden('image_order','')}}
{{Form::submit(trans('form.button_valid'))}}

{{Form::close()}}

@stop