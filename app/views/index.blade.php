@extends('layout.layout')

@section('container')

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
	<!--end pays-->

	<div id="moteur-recherche">
		<form action="locations-de-vacances.php" method="get">
			<!-- DROPDOWN TYPE -->
			<div class="search-select-large">
				<select name="housing_type" class="input1 onChange jqTransform" id="housing_type" value="">
					<option value=""></option>

					<option value="">
					</option>
				</select>
			</div>

			<!-- DROPDOWN PAYS -->
			<div class="search-select-large">

				<!-- COUNTRY -->
				<select class="fontSmall onChange select" id="Country" name="Country"
				onChange="if(this.value=='France'){window.location.hash='tab-france';prechangeMap('map_france');}if(this.value=='Italy'){window.location.hash='tab-italy';prechangeMap('map_italie');}if(this.value=='Spain'){window.location.hash='tab-spain';prechangeMap('map_espagne');}SetDiv('div_region',loadphp('dropdown_localisation.php?action=region&id='+this.value));return true;" >
				<option value=""></option>
			</select>
		</div>

		<!-- DROPDOWN REGION -->


		<div class="search-select-large" id="div_region">
			<select class="fontSmall onChange select"  id="Region" name="Region">
				<option value=""></option>
			</select>
		</div>		  

		<!-- DROPDOWN PROVINCE -->
		<div class="search-select-large" id="div_state">
			<select class="fontSmall onChange"  id="Province" name="Province">
				<option value=""></option>
			</select>
		</div>

		<!-- INPUT DATE -->
		<input type="hidden" name="Destination" value="" />
		<div class="search-select-date-large">
			<label for="Arrival"></label>
			<input type="text" id="Arrival" name="Arrival" />
		</div>
		<!--end search-select-->
		<div class="search-select-date-large">
			<label for="Arrival"></label>
			<input type="text" id="Departure" name="Departure" />
		</div>
		<!--end search-select-->

		<!--  INPUT TEXTE  -->
		<div class="search-input-box-large">
			<label for="reference"></label>
			<input type="text" name="reference" placeholder="" class="search-input-home" title="" />
		</div>

		<!--  BOUTON RECHERCHE  -->
		<input id="bouton-recherche-large" name="action" type="submit" class="button1" value="	" />
		<!--input type="hidden" name="Region" id="Region" value="" /-->
	</form>
</div>
<!--end moteur-recherche--> 
</div>
<!--end recherche-pays-->
@stop