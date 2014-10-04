@extends('layout.layout')

@section('container')
<div id="search">
  <div id="accroche-search">
    <h1 id="h-recherche-detaillee">
      {{ trans('general.trouverUneLocation') }}
    </h1>

             <div style="padding:0px 0px 0px 30px;width:400px;position:absolute;left:280px;top:123px;" >
             {{ Form::open(['route'=>'homeQuickSearch','method'=>'get','id'=>'homeQuickSearch']) }}
            <input type="text" name="c" id="c" style="display:none;height:0px" />
            {{ Form::input('search','quickSearch',null, ['autofocus','id'=>'quickSearch','autocomplete'=>'off','placeholder'=>trans('form.homeQuickSearch')]) }}
            <a id="sautocsearch" name="sautocsearch" href="javascript:document.formAutoSearch.submit();" ><img src="./images/btn.png" /></a>
            {{ Form::close() }}
            <div id="quickSearchResult"></div>
        </div>

  </div>
  <!--end accroche-search-->
<div id="recherche-pays">

	<div id="pays">
		<div class="tab_container_search" id="tab_container_search_map">
			<div class="map_france">
			</div>
		</div>

		<ul class="tabs-menu-recherche-pays">
			<li id="france-btn"><a href="#tab-france"></a></li>
			<li id="italy-btn"><a href="#tab-italy"></a></li>
			<li id="spain-btn"><a href="#tab-spain"></a></li>
			<li id="world-btn"><a href=""></a></li>
		</ul>
	</div>

	<div class="search_errors">
	</div>
	<div class="search_loader">
	</div>

	<!--end pays-->
	<div id="moteur-recherche">
		{{ Form::open(array('route'=>'homeSearch','method'=>'GET','data-exist'=>'true')) }}
			<!-- DROPDOWN TYPE -->
			<div class="search-select-large">
				{{ Form::select('house_type', $typeBatimentList, Session::has('home_search.house_type') ? Session::get('home_search.house_type') : null, ['id'=>'housing_type','class'=>'input1 onChange jqTransform']) }}
			</div>

			<!-- DROPDOWN PAYS -->
			<div class="search-select-large">

				<!-- COUNTRY -->
				<!--<select class="fontSmall onChange select" id="Country" name="Country"
				onChange="if(this.value=='France'){window.location.hash='tab-france';prechangeMap('map_france');}if(this.value=='Italy'){window.location.hash='tab-italy';prechangeMap('map_italie');}if(this.value=='Spain'){window.location.hash='tab-spain';prechangeMap('map_espagne');}SetDiv('div_region',loadphp('dropdown_localisation.php?action=region&id='+this.value));return true;" >
				<option value=""></option>
			</select>-->
			{{ Form::select('country', $paysList, Session::has('home_search.country') ? Session::get('home_search.country') : null, ['id'=>'Country','class'=>'fontSmall onChange select']) }}
		</div>

		<!-- DROPDOWN REGION -->


		<div class="search-select-large" id="div_region">
			<select class="fontSmall onChange select" data-session="{{ Session::has('home_search.region') ? Session::get('home_search.region') : null }}" id="Region" name="region">
				<option value="">{{ trans('form.region') }}</option>
			</select>

		</div>		  

		<!-- DROPDOWN PROVINCE -->
		<div class="search-select-large" id="div_state">
			<select class="fontSmall onChange"  id="Province" data-session="{{ Session::has('home_search.sousRegion') ? Session::get('home_search.sousRegion') : null }}" name="sousRegion">
				<option value="">{{ trans('form.sous_region'); }}</option>
			</select>
		</div>

		<!-- INPUT DATE -->
		<input type="hidden" name="Destination" value="" />
		<div class="search-select-date-large">
			<label for="Arrival">{{ trans('form.start_date') }}</label>
			<input type="text" id="Arrival" class="date" name="start_date" />
		</div>
		<!--end search-select-->
		<div class="search-select-date-large">
			<label for="Arrival">{{ trans('form.end_date') }}</label>
			<input type="text" id="Departure" class="date" name="end_date" />
		</div>
		<!--end search-select-->

		<!--  INPUT TEXTE  -->
		<div class="search-input-box-large">
			<label for="reference"></label>
			<input type="text" name="reference" placeholder="{{ trans('form.ref') }}" class="search-input-home" title="" />
		</div>

		<!--  BOUTON RECHERCHE  -->
		<input id="bouton-recherche-large" type="submit" class="button1" value="{{ trans('form.rechercher') }}" />
		<!--input type="hidden" name="Region" id="Region" value="" /-->
	{{ Form::close() }}
</div>
<!--end moteur-recherche--> 
</div>
<!--end recherche-pays-->
@stop