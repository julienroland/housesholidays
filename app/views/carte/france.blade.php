	<img src="./map/void.png" alt="Image transparente" usemap="#Map"/>
	<map name="Map" id="Map">

    <!-- location-Pays-Région-->

    @foreach( $regions as $region)

    <area href="{{route('rechercheCarte',array('pays'=>$pays->paysTraduction[0]->nom,'region'=>$region->nom))}}" alt="{{trans('general.location_en')}} {{$region->nom}}" title="{{$region->nom}}" shape="poly" coords="{{$region->coords}}"/>

    @endforeach

  </map>
  <div class="overlay"></div>
  <div class="tooltip"></div>
