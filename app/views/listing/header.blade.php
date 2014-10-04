  <h1 id="nombre-resultat">
		Locations vacances  Monde	  </h1>
      <ul id="menu2-list"></ul>
      <!--end menu2-list-->

      <p class="fil-recherche">
		 <p id='arianne5'>
		 <a href="{{ route('rechercheCarte', array('pays'=>trans('general.monde'))) }}">Monde</a>

	@include('listing.filariane')

		 </p>

        		<div class="selection-page">
        		@include('listing.pagination')
        		</p>
    @if(isset($paysWithPropriete))

          <div id="liste-header-recherche">
          <ul>
          @foreach($paysWithPropriete as $pays)
              <li>
                   <a href="{{ route('rechercheCarte', array('pays'=>$pays->paysTraduction[0]->nom)) }}">{{ $pays->paysTraduction[0]->nom }} ({{ Helpers::isOk($pays->propriete) ? $pays->propriete[0]->count: 0 }})</a>
              </li>
              @endforeach
          </ul>

          </div>
        @endif

    @if(isset($regionWithPropriete))
    
        <div id="liste-header-recherche">
        <ul>
        @foreach($regionWithPropriete as $region)
            <li>
                 <a href="{{ route('rechercheCarte', array('pays'=>$region->pays->paysTraduction[0]->nom,'region'=>$region->regionTraduction[0]->nom)) }}">{{ $region->regionTraduction[0]->nom }} ({{ Helpers::isOk($region->propriete) ? $region->propriete[0]->count: 0 }})</a>
            </li>
            @endforeach
        </ul>

        </div>
      @endif

        @if(isset($sousRegionWithPropriete))

              <div id="liste-header-recherche">
              <ul>
              @foreach($sousRegionWithPropriete as $sousRegion)

                  <li>
                       <a href="{{ route('rechercheCarte', array('pays'=>$sousRegion->region->pays->paysTraduction[0]->nom,'region'=>$sousRegion->region->regionTraduction[0]->nom,'sousRegion'=>$sousRegion->sousRegionTraduction[0]->nom)) }}">{{ $sousRegion->sousRegionTraduction[0]->nom }} ({{ Helpers::isOk($sousRegion->propriete) ? $sousRegion->propriete[0]->count: 0 }})</a>
                  </li>
                  @endforeach
              </ul>

              </div>
            @endif

 