<div id="recherche-min">
      <span id="recherche">Recherche</span>
      <div id="moteur-recherche-min">

        {{ Form::open(array('route'=>'homeSearch','method'=>'GET','data-exist'=>'true')) }}
        			<!-- DROPDOWN TYPE -->
        			<div class="search-select-min">
        				{{ Form::select('house_type', $typeBatimentList, Session::has('home_search.house_type') ? Session::get('home_search.house_type') : null, ['id'=>'housing_type','class'=>'input1 onChange jqTransform']) }}
        			</div>

        			<!-- DROPDOWN PAYS -->
        			<div class="search-select-min">

        				<!-- COUNTRY -->
        				<!--<select class="fontSmall onChange select" id="Country" name="Country"
        				onChange="if(this.value=='France'){window.location.hash='tab-france';prechangeMap('map_france');}if(this.value=='Italy'){window.location.hash='tab-italy';prechangeMap('map_italie');}if(this.value=='Spain'){window.location.hash='tab-spain';prechangeMap('map_espagne');}SetDiv('div_region',loadphp('dropdown_localisation.php?action=region&id='+this.value));return true;" >
        				<option value=""></option>
        			</select>-->
        			{{ Form::select('country', $paysList, isset($paysView) ? $paysView->pays_id : ( Session::has('home_search.country') ? Session::get('home_search.country') : null) , ['id'=>'Country','class'=>'fontSmall onChange select']) }}
        		</div>

        		<!-- DROPDOWN REGION -->


        		<div class="search-select-min" id="div_region">
        			<select class="fontSmall onChange select" data-session="{{ Session::has('home_search.region') ? Session::get('home_search.region') : null }}" id="Region" name="region">
        				<option value="">{{ trans('form.region') }}</option>
        			</select>

        		</div>

        		<!-- DROPDOWN PROVINCE -->
        		<div class="search-select-min" id="div_state">
        			<select class="fontSmall onChange"  id="Province" data-session="{{ Session::has('home_search.sousRegion') ? Session::get('home_search.sousRegion') : null }}" name="sousRegion">
        				<option value="">{{ trans('form.sous_region'); }}</option>
        			</select>
        		</div>

                <div class="text-drop-box-min">
                <label for="min">
                <p>{{ trans('form.min') }}</p>
                </label>
                {{ Form::select('min', Config::get('var.min_price'),null, array('id'=>'min', 'class'=>'fontSmall onChange')) }}
                </div>

                <div class="text-drop-box-min">
                <label for="max">
                <p>{{ trans('form.max') }}</p>
                </label>
                {{ Form::select('max', Config::get('var.max_price'),null, array('id'=>'max', 'class'=>'fontSmall onChange')) }}
                </div>
                <p class="info">{{ trans('form.euro_parsemaine') }}</p>

        		<!-- INPUT DATE -->
        		<input type="hidden" name="Destination" value="" />
        		<div class="search-select-date-min">
        			<label for="Arrival">{{ trans('form.start_date') }}</label>
        			<input type="text" id="Arrival" class="date" name="start_date" />
        		</div>
        		<!--end search-select-->
        		<div class="search-select-date-min">
        			<label for="Arrival">{{ trans('form.end_date') }}</label>
        			<input type="text" id="Departure" class="date" name="end_date" />
        		</div>
        		<!--end search-select-->

                <div class="text-drop-box-min">
                <label for="Chambres">
                <p>{{ trans('form.Chambres') }}</p>
                </label>
                {{ Form::select('Chambres', Config::get('var.nombre_chambres'), null, array('id'=>'Chambres', 'class'=>'fontSmall onChange')) }}
                </div>


                <div class="text-drop-box-min">
                <label for="couchages">
                <p>{{ trans('form.Literie') }}</p>
                </label>
                {{ Form::select('couchages', Config::get('var.nombre_chambres'), null, array('id'=>'couchages', 'class'=>'fontSmall onChange')) }}
                </div>
                
                <div>
                <span class="menulinks close">
                {{  trans('form.plus_options') }}▼
                </span>
                </div>

                <div id="moreoptions">

                </div>
        		<!--  BOUTON RECHERCHE  -->
        		<input id="bouton-recherche-min" type="submit" class="button1" value="{{ trans('form.rechercher') }}" />
        		<!--input type="hidden" name="Region" id="Region" value="" /-->
        	{{ Form::close() }}

      </div>
 </div>

 