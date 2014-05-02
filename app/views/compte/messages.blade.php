@extends('layout.layout')

@section('container')

@if($messagesReceive->count())
Message Reçus
@foreach($messagesReceive as $message)

<div class="messages">
	<p>{{$message->prenom}} {{$message->nom}} </p>

	@if(Helpers::isOk($message->depart))

	<p>Date départ:{{Helpers::beTime(Helpers::createCarbonDate($message->depart),'$d $nd $M $y')}} ({{Helpers::createCarbonDate($message->depart)->diffForHumans()}})</p>

	@endif

	@if(Helpers::isOk($message->arrive))

	<p>Date arrivé: {{Helpers::beTime(Helpers::createCarbonDate($message->arrive),'$d $nd $M $y')}} ({{Helpers::createCarbonDate($message->arrive)->diffForHumans()}})</p>

	@endif

	{{Helpers::beTime($message->created_at,'$d $nd $M $y')}} ({{$message->created_at->diffForHumans()}})
	<p>
		{{$message->texte}}
	</p>

	<a href="#contact" class="inline lightbox">{{trans('general.repondre')}}</a>
	<div style="display:none">
		<div id="contact">
			{{Form::open(array('route'=>'repondre_message','id'=>'repondreMessage'))}}

			{{Form::textarea('message','',array('placeholder'=>trans('form.reponse').'*','required'))}}

			{{Form::hidden('sender_id', Auth::check()  ? Auth::user()->id: $message->vers_user_id)}}
			{{Form::hidden('propriete_id',$message->propriete_id)}}
			{{Form::hidden('receiver_id',$message->de_user_id)}}
			{{Form::hidden('message_id',$message->id)}}

			{{Form::submit(trans('form.button_send'))}}
			{{Form::close()}}

		</div> 
	</div>
</div>
<br>
@endforeach

{{$messagesReceive->links()}}

@endif

Message Envoyé

@if(Helpers::isOk($messagesSend))

@foreach($messagesSend as $message)

<div class="messages">
	<p>{{$message->prenom}} {{$message->nom}} </p>

	@if(Helpers::isOk($message->depart))

	<p>Date départ:{{Helpers::beTime(Helpers::createCarbonDate($message->depart),'$d $nd $M $y')}} ({{Helpers::createCarbonDate($message->depart)->diffForHumans()}})</p>

	@endif

	@if(Helpers::isOk($message->arrive))

	<p>Date arrivé: {{Helpers::beTime(Helpers::createCarbonDate($message->arrive),'$d $nd $M $y')}} ({{Helpers::createCarbonDate($message->arrive)->diffForHumans()}})</p>

	@endif

	{{Helpers::beTime($message->created_at,'$d $nd $M $y')}} ({{$message->created_at->diffForHumans()}})
	<p>
		{{$message->texte}}
	</p>
</div>
<br>
@endforeach

{{$messagesSend->links()}}

@endif

@stop

