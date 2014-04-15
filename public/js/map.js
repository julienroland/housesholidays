/* HEPL RIA 2013 - Test One
 *
 * JS Document - /js/main.js
 *
 * coded by [Julien Roland]
 * started at 28/10/13
 */

 /* jshint boss: true, curly: true, eqeqeq: true, eqnull: true, immed: true, latedef: true, newcap: true, noarg: true, browser: true, jquery: true, noempty: true, sub: true, undef: true, unused: true, white: false */
 ;(function( $ ){
 	"use strict";

 	var gMap,
 	gStartPosition = new google.maps.LatLng( 50.833 , 4.333 ),
 	sPosition,
 	gMarker,
 	oData,
 	sCurrentPosition,
 	nZoomAdresse = 16,
 	nZoomZone = 8,
 	nZoomSousRegion = 11,
 	nZoomLocalite = 15,
 	$adresse = $('#adresse'),
 	$pays = $('#pays'),
 	$region = $('#region'),
 	$localite = $('#localite'),
 	$sousRegion = $('#sous_region'),
 	$latlng = $('#latlng'),
 	sAdresse,
 	sPays,
 	sRegion,
 	sSousRegion,
 	sLocalite,
 	lat,
 	lng,
 	icon_marker = '/img/marker.png',
 	geocoder = new google.maps.Geocoder();

 	$(function(){

 	});

 	var initialize = function(){

 		displayGoogleMap();

 		$('#rechercheMap').on('click', function( e ){

 			e.preventDefault();
 			getPosition( 'geocoder' );
 			

 		});
 		/*if( $adresse.val() !== "" && $adresse.val() !== null){

 			sPosition = $adresse.val();
 			getPosition( geocoder,  sPosition, 'adresse' );
 		}*/

 		$adresse.on('change', function(){

 			getPosition( "geocoder", $(this).val(), "adresse" );

 		});

 		$pays.on('change', function(){

 			getPosition( "geocoder", $(this).find('option:selected').text(), "pays" );

 		});

 		$region.on('change', function(){

 			getPosition( "geocoder", $(this).val(), "region" );

 		});

 		$sousRegion.on('change', function(){

 			getPosition( "geocoder", $(this).val(), "sous_region" );

 		});

 		$localite.on('change', function(){

 			getPosition( "geocoder", $(this).val(), "localite" );

 		});


 	};

 	var displayGoogleMap = function(){

 		gMap = new google.maps.Map(document.getElementById('gmap'),{
 			center:gStartPosition,
 			zoom:4,
 			disableDefaultUI:false,
 			scrollwheel:false,
 			mapTypeId:google.maps.MapTypeId.ROADMAP,
 		});

 	};

 	var getPosition = function( sType , sPosition, sTypePartAdresse ){

 		if(sType === "geocoder"){

 			if(typeof sPosition !== "undefined"){

 				if(sTypePartAdresse === "adresse"){

 					sAdresse = $adresse.val();

 				}
 				else if( sTypePartAdresse === "pays" ){

 					sPays = $pays.find('option:selected').text();

 				}
 				else if( sTypePartAdresse === "region" ){

 					sRegion = $region.find('option:selected').text();	

 				}
 				else if( sTypePartAdresse === "sous_region" ){

 					sSousRegion = $sousRegion.find('option:selected').text();

 				}
 				else if( sTypePartAdresse === "localite" ){

 					sLocalite = $localite.find('option:selected').text();

 				}

 			}
 			else{

 				var sAdresse = $(this).val();

 			}

 			if(!sPays){

 				sPays = $('#pays option:selected').text();

 			}
 			if(!sRegion){

 				sRegion = $('#region option:selected').text();

 			}
 			if(!sSousRegion){

 				sSousRegion = $('#sous_region option:selected').text();

 			}
 			if(!sSousRegion){

 				sSousRegion = $('#sous_region option:selected').text();

 			}
 			if(!sLocalite){

 				sLocalite = $('#localite option:selected').text();
 			}
 			if(!sAdresse){

 				sAdresse = $('#adresse').val();
 			}

 			var aMapOptions = {
 				disableDefaultUI:true,
 				scrollwheel:false,
 				mapTypeId: google.maps.MapTypeId.ROADMAP,
 				center:geocoder.geocode({

 					address:sAdresse + ' ' + sLocalite + ' ' + ' ' + sSousRegion + ' ' + sRegion + ' ' + sPays,

 				},function(aResults,sStatus)
 				{
 					if(sStatus === google.maps.GeocoderStatus.OK)
 					{
 						oData = aResults[0];

 						lat = oData.geometry.location.lat();
 						lng = oData.geometry.location.lng();

 						sCurrentPosition = new google.maps.LatLng( lat , lng );
 						$latlng.val( " " );
 						$latlng.val( lat + ',' + lng );

 						if(typeof gMarker === 'undefined'){

 							$latlng.val( " " );
 							$latlng.val( lat + ',' + lng );
 							createMarker( sCurrentPosition );
 							gMap.panTo( sCurrentPosition );

 							if(sTypePartAdresse === "adresse"){

 								gMap.setZoom( nZoomAdresse );

 							}
 							else if( sTypePartAdresse === "sous_region" )
 							{

 								gMap.setZoom( nZoomSousRegion );


 							}
 							else if( sTypePartAdresse === "localite" ){


 								gMap.setZoom( nZoomLocalite );


 							}
 							else
 							{

 								gMap.setZoom( nZoomZone );

 							}

 						}
 						else
 						{

 							$latlng.val( " " );
 							$latlng.val( lat + ',' + lng );
 							gMarker.setPosition( sCurrentPosition );
 							gMap.panTo( sCurrentPosition );

 							if(sTypePartAdresse === "adresse"){

 								gMap.setZoom( nZoomAdresse );

 							}
 							else if( sTypePartAdresse === "sous_region" )
 							{

 								gMap.setZoom( nZoomSousRegion );


 							}
 							else if( sTypePartAdresse === "localite" ){


 								gMap.setZoom( nZoomLocalite );


 							}
 							else
 							{

 								gMap.setZoom( nZoomZone );

 							}

 						}

 					}
 				})
}
}
else
{	

	$latlng.val( " " );
	$latlng.val( sPosition.lat() + ',' + sPosition.lng() );
	gMap.panTo( sPosition );
}

};
var createMarker = function( gLatLng ){

	gMarker = new google.maps.Marker({
		position:gLatLng,
		animation: google.maps.Animation.DROP,
		map : gMap,
		draggable: true,
		visible: true,
		icon: icon_marker
	});

	google.maps.event.addListener(gMarker, 'dragend', function( e ) {

		getPosition ( "latlng" , new google.maps.LatLng( e.latLng.lat() , e.latLng.lng() ));
		
	});
	google.maps.event.addListener(gMarker, 'click', function( e ) {

		gMap.setZoom(18);
		gMap.panTo(new google.maps.LatLng( e.latLng.lat() , e.latLng.lng() ));
		
	});


};
var updatePosition = function(  ){
	var gMyPosition = new google.maps.LatLng( oMyPosition.latitude , oMyPosition.longitude );
	gMap.panTo( gMyPosition );

};


google.maps.event.addDomListener(window, 'load', initialize);

}).call(this,jQuery);