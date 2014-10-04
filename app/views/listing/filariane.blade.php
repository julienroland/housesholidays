
@if(isset($filariane))

@if(Helpers::isOk($filariane->pays))
&rsaquo; <a href="{{  route('rechercheCarte', array('pays'=>$filariane->pays)) }}">{{ $filariane->pays }}</a>
@endif

@if(Helpers::isOk($filariane->region))
&rsaquo; <a href="{{  route('rechercheCarte', array('pays'=>$filariane->pays, 'region'=>$filariane->region)) }}">{{ $filariane->region }}</a>
@endif

@if(Helpers::isOk($filariane->sous_region))
&rsaquo; <a href="{{  route('rechercheCarte', array('pays'=>$filariane->pays, 'region'=>$filariane->region, 'sousRegion'=>$filariane->sous_region)) }}">{{ $filariane->sous_region }}</a>
@endif
@endif

