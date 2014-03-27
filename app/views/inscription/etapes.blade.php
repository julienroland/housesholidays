<div class="etapes">

@if(Session::get('etape2')  && $page != 'inscription_etape2')

{{link_to_route('etape1Index', trans('form.revenir_etape',array('numero'=>2)),Auth::user()->slug)}}

@elseif( $page === 'inscription_etape2')

<span class="current">{{trans('form.etape', array('numero'=>2))}}</span>

@else

<span>{{trans('form.etape', array('numero'=>2))}}</span>

@endif

@if(Session::get('etape3') && $page != 'inscription_etape3')

{{link_to_route('etape2Index', trans('form.revenir_etape',array('numero'=>2)),Auth::user()->slug)}}

@elseif( $page === 'inscription_etape3')

<span class="current">{{trans('form.etape', array('numero'=>3))}}</span>

@else

<span>{{trans('form.etape', array('numero'=>3))}}</span>

@endif
</div>