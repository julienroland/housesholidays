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
 	icon_marker = '/images/marker.png',
 	geocoder = new google.maps.Geocoder();

 	$(function(){

 	});

 	var initialize = function(){

 		getData();
 		displayGoogleMap();

 	};
 	var getData = function(){

 		gStartPosition = new google.maps.LatLng( getLatLng( $('#gmap').attr('data-location'),'lat'), getLatLng($('#gmap').attr('data-location'),'lng') );

 	};
 	var getLatLng = function( value, type ){

 		if(type ==='lat'){

 			return value.split(',')[0];

 		}else if(type ==='lng'){

 			return value.split(',')[1];
 		}
 	}
 	var displayGoogleMap = function(){

 		gMap = new google.maps.Map(document.getElementById('gmap'),{
 			center:gStartPosition,
 			zoom:4,
 			disableDefaultUI:false,
 			scrollwheel:false,
 			mapTypeId:google.maps.MapTypeId.ROADMAP,
 		});


 			createMarker(gStartPosition);
 			gMap.setCenter(gStartPosition);
 			gMap.setZoom(15);


 	};

 	var getPosition = function( sType , sPosition, sTypePartAdresse ){

 		
};
var createMarker = function( gLatLng ){

	gMarker = new google.maps.Marker({
		position:gLatLng,
		animation: google.maps.Animation.DROP,
		map : gMap,
		visible: true,
		icon: icon_marker
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