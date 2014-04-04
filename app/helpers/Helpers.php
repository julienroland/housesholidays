<?php

use Carbon\Carbon;

class Helpers {

	public static function toEuShortDate( $date ){

		$ex = explode( '-', $date );
		$mois_id =(int)($ex['1']);
		return (int)($ex['2']).' '.trans('general.mois')[$mois_id].' '.$ex['0'];

	}
	/**
	*
	* Convertis une date fr format dd/mm/yy vers une date serveur format yy-mm-dd
	*
	**/
	
	public static function toServerDate( $date ){

		if( explode('-', $date) ){

			$dateEx = explode('-', $date);

			return $dateEx[2].'-'.$dateEx[1].'-'.$dateEx[0];

		}
		elseif( explode('/', $date) )
		{
			$dateEx = explode('/', $date);

			return $dateEx[2].'-'.$dateEx[1].'-'.$dateEx[0];
		}
	}
	/**
	*
	* Images
	*
	**/
	public static function replaceExtension( $string, $extension ){

		$stringEx = explode( '.', $string );

		return $stringEx[0].'.'.$extension;
	}

	public static function getLangRoute( $route ){

		return Lang::get('routes.'.str_replace(App::getLocale().'/','',$route));
	}

	public static function addBeforeExtension( $stringWithExt, $string ){

		$stringEx = explode( '.', $stringWithExt );

		return Helpers::toSlug( $stringEx[0].' '.$string.'.'.$stringEx[1] );

	}
	/**
	*
	* Ajoute le timestamp dans le nom de l'image
	*
	**/

	public static function addTimestamp( $image , $type = null , $ext = null, $timestamp = null ){

		if(Helpers::isOk( $image )  &&  explode( '.', $image )){

			$imageEx = explode( '.', $image );

			if( Helpers::isNotOk( $timestamp )){

				$name = $imageEx[0].date('dmYhis'); 
			}
			else{
				
				$name = $imageEx[0].$timestamp; 
			}

			if( Helpers::isOk( $ext )){

				$extension = $ext;
			}
			else
			{
				$extension = $imageEx[1]; 

			}
			if( Helpers::isOk( $type )){

				return $name.$type. '.' .$extension;
			}
			else
			{
				return $name. '.' .$extension;	
			}
			
		}
		else
		{

			return false;

		}
	}

	

	/**
	*
	* Retourne l'id d'une langue sous base de son initial ( 'fr' retournera l'id 1) 
	*
	**/
	public static function getLangId( $langId )
	{
		if(Helpers::isOk( $langId , 'int'))
		{

			return $langId;

		}else{

			return (int)Language::whereShort(Config::get('app.locale'))->first(['id'])->id;
		}
	}

	/**
	*
	* Convertis une string vers une string sluge (informations très personnelles => informations-tres-personnelles)
	*
	**/
	public static function toSlug( $string ){

		return str_replace(' ' , '-' , strtolower( $string ) );

	}
	/**
	*
	* Extrait la latitude ou longitude du texte de format (lat,lng)
	*
	**/
	public static function extractLatLng( $latlng , $type ){

		if(Helpers::isOk( $latlng )){

			$explode = explode(',' , $latlng);

			if(
				$type === 'lat'
				|| $type === 'Lat'
				||$type == '0'
				){

				return  (int)$explode[0];
		}
		elseif(
			$type === 'lng' 
			|| $type === 'Lng' 
			|| $type == '0'
			){

			return (int)$explode[1];
	}
}else{

	return false;
}



}

/**
*
* Test si la valeur est bonne, return true, sinon false
*
**/
public static function isOk ( $data , $type = ""){

	if(!empty( $type )){

		if( isset($data->errors) ){

			return false;
		}
		else{

			if(
				isset($data)
				&& $data !== "undefined"
				&& $data!== null
				&& count($data) > 0
				&& $data === $type	
				&& !empty( $data )
				){

				return true;

		}else{

			return false;

		}
	}
}else{

	if( isset($data->errors) ){
		return false;
	}else{

		if(
			isset($data)
			&& $data !== "undefined"
			&& $data!== null
			&& count($data) > 0
			&& !empty( $data )
			){

			return true;

	}else{

		return false;

	}
}
}
}

/**
*
* Test si la valeur n'est pas bonne, return true, sinon false
*
**/
public static function isNotOk ( $data , $type = ""){

	if(!empty( $type )){

		if( isset($data->errors) ){
			
			return true;
		}else{

			if(
				!isset($data)
				|| empty( $data )
				|| $data === null
				|| count($data) <= 0
				|| $data !== $type	
				){

				return true;

		}else{

			return false;

		}
	}

}else{

	if( isset($data->errors) ){

		return true;

	}else{

		if(
			!isset($data)
			|| $data === null
			|| empty( $data )
			|| count($data) <= 0
			){

			return true;

	}else{

		return false;

	}
}

}

}
/**
*
* Convertis date de format NA en format Eu
*
**/

public static function dateEu( $date ){

	$dateExplode = explode('-',$date);

	return $dateExplode[2].'/'. $dateExplode[1].'/'.$dateExplode[0];
}

/**
*
* Convertis en pourcentage 
*
**/
public static function toPercent( $value , $on )
{
	if($on != 0){
		return ($value / $on ) * 100;
	}
	else{

		return NULL;
	}

}

/**
*
* Convertis les dates Eu en versio Na
*
**/
public static function dateNaForm( $date , $separator = '-'){

	$dateExplode = explode($separator,$date);

	return $dateExplode[2].$separator.$dateExplode[1].$separator.$dateExplode[0];
}

/**
*
* Creer une instance de Carbon avec une date
*
**/

public static function createCarbonDate( $date , $type = 'us', $separator = '-' ){

	if($type === 'us'){

		$dateExplode = explode($separator,$date);

		return Carbon::createFromDate($dateExplode[0], $dateExplode[1], $dateExplode[2]);

	}
	elseif( $type === 'eu'){

		$dateExplode = explode($separator,$date);

		return Carbon::createFromDate($dateExplode[2], $dateExplode[1], $dateExplode[0]);
	}

}

/**
*
* Convertis le numero des jours en texte 
*
**/
public static function humanDay( $date ){

	switch ($date) {
		case 0:
		return "Dimanche";
		break;
		case 1:
		return "Lundi";
		break;
		case 2:
		return "Mardi";
		break;
		case 3:
		return "Mercredi";
		break;
		case 4:
		return "Jeudi";
		break;
		case 5:
		return "Vendredi";
		break;
		case 6:
		return "Samedi";
		break;

	}
}


}