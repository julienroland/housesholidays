<div class="etapes">

	@for($i=2; $i<=8;$i++)

		@if(Session::get('etape'.$i) && $page != 'inscription_etape'.$i || $page != 'inscription_etape'.$i && Session::get('etape'.$i))

		{{link_to_route('etape'.($i-1).'Index', trans('form.revenir_etape',array('numero'=>$i)),Auth::user()->slug)}}

		@elseif( $page === 'inscription_etape'.$i)

		<span class="current">{{trans('form.etape', array('numero'=>$i))}}</span>

		@else

		<span>{{trans('form.etape', array('numero'=>$i))}}</span>

		@endif
		
	@endfor


</div>