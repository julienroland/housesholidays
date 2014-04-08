<div class="etapes">

	@for($i=2; $i<=Config::get('var.etape');$i++)

	@if(Session::get('etape'.($i-1))  && $page != 'inscription_etape'.$i  && !Session::has('etape'.$i) )

	{{link_to_route('etape'.($i-1).'Index', trans('form.aller_etape',array('numero'=>$i)),Auth::user()->slug)}}
	
	@else

		@if(Session::get('etape'.$i) && $page != 'inscription_etape'.$i )

		{{link_to_route('etape'.($i-1).'Index', trans('form.revenir_etape',array('numero'=>$i)),Auth::user()->slug)}}

		@elseif( $page === 'inscription_etape'.$i)

		<span class="current">{{trans('form.etape', array('numero'=>$i))}}</span>

		@else

		<span>{{trans('form.etape', array('numero'=>$i))}}</span>

		@endif

	@endif

	@endfor


</div>