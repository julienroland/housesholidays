;(function( $ ){
$(function(){
console.log('ok');
$('#italy-btn>a').click(function(){ // Si click sur italie
	if(!$('#tab_container_search_map>div').hasClass('map_italie')){
		$('#tab_container_search_map>div').empty();
		$('#tab_container_search_map>div').unbind();
		$('#tab_container_search_map>div').attr('class','map_italie');
		var pays=$('#tab_container_search_map>div').attr('class');
		$('#tab_container_search_map>div').css({'width':'244px'});	
		var nom_pays=pays.substr(4);
		$('#tab_container_search_map>div').load('../map/'+nom_pays+'.html');
		changeMap(pays);
	}
});	
	$('#spain-btn>a').click(function(){ // Si click sur espagne

		if(!$('#tab_container_search_map>div').hasClass('map_espagne')){
			$('#tab_container_search_map>div').empty();
			$('#tab_container_search_map>div').unbind();
			$('#tab_container_search_map>div').attr('class','map_espagne');
			var pays=$('#tab_container_search_map>div').attr('class');
			$('#tab_container_search_map>div').css({'width':'369px'});	
			var nom_pays=pays.substr(4);
			$('#tab_container_search_map>div').load('../map/'+nom_pays+'.html');
			changeMap(pays);
		}
	});	
	$('#france-btn>a').click(function(){ // Si click sur france
		if(!$('#tab_container_search_map>div').hasClass('map_france')){
			$('#tab_container_search_map>div').empty();
			$('#tab_container_search_map>div').unbind();
			$('#tab_container_search_map>div').attr('class','map_france');
			var pays=$('#tab_container_search_map>div').attr('class');
			$('#tab_container_search_map>div').css({'width':'223px'});	
			var nom_pays=pays.substr(4);
			$('#tab_container_search_map>div').load('../map/'+nom_pays+'.php');
			changeMap(pays);
		}
	});	
	if(!pays){ // Chargement de la page, en gros, si pas de click
		$('#tab_container_search_map>div').empty();
		$('#tab_container_search_map>div').unbind();
		var pays=$('#tab_container_search_map>div').attr('class');
		var nom_pays=pays.substr(4);
		$('#tab_container_search_map>div').load('/'+nom_pays);
		changeMap(pays);
	}
});	

	var prechangeMap = function (pays)
	{
		switch(pays){
			case "map_espagne":	
			if(!$('#tab_container_search_map>div').hasClass('map_espagne')){
				$('#tab_container_search_map>div').empty();
				$('#tab_container_search_map>div').unbind();
				$('#tab_container_search_map>div').attr('class','map_espagne');
				var pays=$('#tab_container_search_map>div').attr('class');
				$('#tab_container_search_map>div').css({'width':'369px'});	
				var nom_pays=pays.substr(4);
				$('#tab_container_search_map>div').load('../map/'+nom_pays+'.html');
				changeMap(pays);}		
				break;
				case "map_italie":
				if(!$('#tab_container_search_map>div').hasClass('map_italie')){
					$('#tab_container_search_map>div').empty();
					$('#tab_container_search_map>div').unbind();
					$('#tab_container_search_map>div').attr('class','map_italie');
					var pays=$('#tab_container_search_map>div').attr('class');
					$('#tab_container_search_map>div').css({'width':'244px'});	
					var nom_pays=pays.substr(4);
					$('#tab_container_search_map>div').load('../map/'+nom_pays+'.html');
					changeMap(pays);	}	
					break;
					case "map_france":
					if(!$('#tab_container_search_map>div').hasClass('map_france')){
						$('#tab_container_search_map>div').empty();
						$('#tab_container_search_map>div').unbind();
						$('#tab_container_search_map>div').attr('class','map_france');
						var pays=$('#tab_container_search_map>div').attr('class');
						$('#tab_container_search_map>div').css({'width':'223px'});	
						var nom_pays=pays.substr(4);
						$('#tab_container_search_map>div').load('../map/'+nom_pays+'.html');
						changeMap(pays);}
						break;
					}
				}

				var changeMap = function (pays){
					switch(pays){
						case "map_espagne":
			// !!! NE PAS CHANGER L'ORDRE !!!
			$('.map_espagne .tooltip').hide();
			var regions = [ 
			{name : 'Galice', slug: 'Galice'},
			{name : 'Asturies', slug: 'Asturies'},
			{name : 'Cantabrie', slug: 'Cantabrie'},
			{name : 'Pays Basques', slug: 'Pays Basques'},
			{name : 'Navarre', slug: 'Navarre'},
			{name : 'Aragon', slug: 'Aragon'},
			{name : 'Catalogne', slug: 'Catalogne'},
			{name : 'Valence', slug: 'Valence'},
			{name : 'Castille La Manche', slug: 'Castille La Manche'},
			{name : 'Murcie', slug: 'Murcie'},
			{name : 'Andalousie', slug: 'Andalousie'},
			{name : 'Extremadure', slug: 'Extremadure'},
			{name : 'Madrid', slug: 'Madrid'},
			{name : 'Castille Et Leon', slug: 'Castille Et Leon'},
			{name : 'La Rojia', slug: 'La Rojia'},
			{name : 'Canaries', slug: 'Canaries'},
			{name : 'Baleares', slug: 'Baleares'},
			
			];

			// "info-bulle" qui suit la souris
			$(document).on('mousemove','#Map area',function(e){
				$('.map_espagne .tooltip').css({
					top:e.pageY-$('.map_espagne .tooltip').height()-20,
					left:e.pageX-$('.map_espagne .tooltip').width()/2-10
				});
			});
			
			// "region" qui change en fct de la souris	
			$('.map_espagne').on('mouseover','#Map area',function(){
				var index = $(this).index();
				var left = -index * 369 - 369;
				$('.map_espagne .tooltip').html(regions[index].name).stop().fadeTo(500,0.6);	 
				$('.map_espagne .overlay').css({
					backgroundPosition : left+"px 0px"		 
				}); 
			});

			// "region" qui disparait quand la souris sort de l'img	
			$('.map_espagne').on('mouseout','#Map area',function(){
				$('.map_espagne .overlay').css({
					backgroundPosition : "369px 0px"		 
				}); 
				$('.map_espagne .tooltip').stop().fadeTo(500,0);
			});		
			break;
			case "map_italie":
			// !!! NE PAS CHANGER L'ORDRE !!!
			$('.map_italie .tooltip').hide();
			var regions = [ 
			{name : 'Valle d&acute;Aoste', slug: 'valle-d-aoste'},
			{name : 'Piemonte', slug: 'piemonte'},
			{name : 'Lombardia', slug: 'lombardia'},
			{name : 'Trentino-Alto Adige', slug: 'trentino-alto-adige'},
			{name : 'Trento', slug: 'trento'},
			{name : 'Friuli Venezia Giulia', slug: 'triuli-venezia-giulia'},
			{name : 'Liguria', slug: 'liguria'},
			{name : 'Emilia-Romagna', slug: 'emilia-romagna'},
			{name : 'Veneto', slug: 'veneto'},
			{name : 'Toscana', slug: 'toscana'},
			{name : 'Marche', slug: 'marche'},
			{name : 'Umbria', slug: 'umbria'},
			{name : 'Lazio', slug: 'lazio'},
			{name : 'Abruzzo', slug: 'abruzzo'},
			{name : 'Campania', slug: 'campania'},
			{name : 'Molise', slug: 'molise'},
			{name : 'Puglia', slug: 'puglia'},
			{name : 'Basilicata', slug: 'basilicata'},
			{name : 'Calabria', slug: 'calabria'},
			{name : 'Sicilia', slug: 'sicilia'},
			{name : 'Sardegna', slug: 'sardegna'},
			];

			// "info-bulle" qui suit la souris
			$(document).on('mousemove','#Map area',function(e){
				$('.map_italie .tooltip').css({
					top:e.pageY-$('.map_italie .tooltip').height()-20,
					left:e.pageX-$('.map_italie .tooltip').width()/2-10
				});
			});
			
			// "region" qui change en fct de la souris	
			$('.map_italie').on('mouseover','#Map area',function(){
				var index = $(this).index();
				var left = -index * 244 - 244;
				$('.map_italie .tooltip').html(regions[index].name).stop().fadeTo(500,0.6);	 
				$('.map_italie .overlay').css({
					backgroundPosition : left+"px 0px"		 
				});
			});

			// "region" qui disparait quand la souris sort de l'img	
			$('.map_italie').on('mouseout','#Map area',function(){
				$('.map_italie .overlay').css({
					backgroundPosition : "244px 0px"		 
				}); 
				$('.map_italie .tooltip').stop().fadeTo(500,0);
			});
			break;
			case "map_france":
			// !!! NE PAS CHANGER L'ORDRE !!!
			$('.map_france .tooltip').hide();
			var regions = [ 
			{name : 'Nord-Pas de Calais', slug: 'nord-pas-de-calais'},
			{name : 'Picardie', slug: 'picardie'},	 
			{name : 'Haute-Normandie', slug: 'haute-normandie'},
			{name : 'Champagne-Adrenne', slug: 'champagne-adrenne'},
			{name : 'Lorraine', slug: 'lorraine'},
			{name : 'Alsace', slug: 'alsace'},
			{name : 'Basse-Normandie', slug: 'basse-normandie'},
			{name : 'Centre', slug: 'centre'},
			{name : 'Île de France', slug: 'ile-de-france'},
			{name : 'Bretagne', slug: 'bretagne'},
			{name : 'Pays de la Loire', slug: 'pays-de-la-loire'},
			{name : 'Bourgogne', slug: 'bourgogne'},
			{name : 'Franche-Comté', slug: 'franche-comte'},
			{name : 'Poitou-Charentes', slug: 'poitou-charentes'},
			{name : 'Limousin', slug: 'limousin'},
			{name : 'Auvergne', slug: 'auvergne'},
			{name : 'Rhône-Alpes', slug: 'rhone-alpes'},
			{name : 'Aquitaine', slug: 'aquitaine'},
			{name : 'Midi-Pyrénées', slug: 'midi-pyrenees'},
			{name : 'Languedoc-Roussillon', slug: 'languedoc-roussillon'},
			{name : 'Provence-Alpes Cote d&acute;Azur', slug: 'provence-alpes-cote-d-azur'},
			{name : 'Corse', slug: 'corse'}
			];

			// "info-bulle" qui suit la souris
			$(document).on('mousemove','#Map area',function(e){
				$('.map_france .tooltip').css({
					top:e.pageY-$('.map_france .tooltip').height()-20,
					left:e.pageX-$('.map_france .tooltip').width()/2-10
				});
			});
			
			// "region" qui change en fct de la souris	
			$('.map_france').on('mouseover','#Map area',function(){
				var index = $(this).index();
				var left = -index * 223 - 223;
				$('.map_france .tooltip').html(regions[index].name).stop().fadeTo(500,0.6);	 
				$('.map_france .overlay').css({
					backgroundPosition : left+"px 0px"		 
				}); 
			});

			// "region" qui disparait quand la souris sort de l'img	
			$('.map_france').on('mouseout','#Map area',function(){
				$('.map_france .overlay').css({
					backgroundPosition : "223px 0px"		 
				}); 
				$('.map_france .tooltip').stop().fadeTo(500,0);
			});	
			break;
		}
	}	

}).call(this, jQuery);