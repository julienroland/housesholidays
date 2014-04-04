<div class="etapes">

@if(Session::get('etape2')  && $page != 'inscription_etape2')

{{link_to_route('etape1Index', trans('form.revenir_etape',array('numero'=>2)),Auth::user()->slug)}}

@elseif( $page === 'inscription_etape2')

<span class="current">{{trans('form.etape', array('numero'=>2))}}</span>

@else

<span>{{trans('form.etape', array('numero'=>2))}}</span>

@endif

@if(Session::get('etape3') && $page != 'inscription_etape3' || $page != 'inscription_etape3' && Session::get('etape2'))

{{link_to_route('etape2Index', trans('form.revenir_etape',array('numero'=>3)),Auth::user()->slug)}}

@elseif( $page === 'inscription_etape3')

<span class="current">{{trans('form.etape', array('numero'=>3))}}</span>

@else

<span>{{trans('form.etape', array('numero'=>3))}}</span>

@endif

@if(Session::get('etape4') && $page != 'inscription_etape4' || $page != 'inscription_etape4' && Session::get('etape3'))

{{link_to_route('etape3Index', trans('form.revenir_etape',array('numero'=>4)),Auth::user()->slug)}}

@elseif( $page === 'inscription_etape4')

<span class="current">{{trans('form.etape', array('numero'=>4))}}</span>

@else

<span>{{trans('form.etape', array('numero'=>4))}}</span>

@endif

@if(Session::get('etape5') && $page != 'inscription_etape5' || $page != 'inscription_etape5' && Session::get('etape4'))

{{link_to_route('etape3Index', trans('form.revenir_etape',array('numero'=>5)),Auth::user()->slug)}}

@elseif( $page === 'inscription_etape5')

<span class="current">{{trans('form.etape', array('numero'=>5))}}</span>

@else

<span>{{trans('form.etape', array('numero'=>5))}}</span>

@endif


</div>