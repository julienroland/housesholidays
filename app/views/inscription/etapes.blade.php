
<nav class="etapes">
	<ol>
		@for($i=2; $i<=Config::get('var.etape');$i++)
		@if(Helpers::isOk($propriete))
		<li class="{{ $page === 'inscription_etape'.$i ? 'current':''}} {{$propriete->etape >= $i ? 'done' : 'notdone'}}">

			@if($propriete->etape <= $i-1  && $page != 'inscription_etape'.$i  && !$propriete->etape >= $i )

			{{link_to_route('etape'.($i-1).'Index', trans('form.aller_etape',array('numero'=>$i)), array(Auth::user()->slug, $propriete->id ))}}

			@else

			@if($propriete->etape >= $i  && $page != 'inscription_etape'.$i )

			{{link_to_route('etape'.($i-1).'Index', trans('form.revenir_etape',array('numero'=>$i)), array(Auth::user()->slug, $propriete->id ))}}

			@elseif( $page === 'inscription_etape'.$i)

			<span class="current">{{trans('form.etape', array('numero'=>$i))}}</span>

			@else

			<span>{{trans('form.etape', array('numero'=>$i))}}</span>

			@endif

			@endif
		</li>
		@else
		<li>
			@if($i==2)

			<span class="current">{{trans('form.etape', array('numero'=>$i))}}</span>

			@else

			<span>{{trans('form.etape', array('numero'=>$i))}}</span>

			@endif
		</li>
		@endif
		@endfor


	</ol>
</nav>