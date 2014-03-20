<?php

use Carbon\Carbon;

class Helpers {
	public static function getLangRoute( $route ){

		return Lang::get('routes.'.str_replace(App::getLocale().'/','',$route));
	}
	/**
	*
	* Si il n'y a aucune session de langue, on refait le parcous pour en définir une
	*
	**/
	public static function ifNotSessionLangId(){

		/*if(Helpers::isNotOk(Session::get('langId'))){

			$langNav = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

			if (helpers::isOk($langNav)) 
			{
				$langue = explode(',',$langNav);
				$langue = strtolower(substr(chop($langue[1]),0,2));

				if (in_array($langue, Config::get('app.available_locales')))
				{
					Session::put('lang',$langue );
					Session::put('langId',Langage::whereInitial($langue)->first(['id'])->id);
					\App::setLocale($langue);
				}
				else
				{

					Session::put('langId', Langage::whereInitial(Config::get('app.locale'))->first(['id'])->id);
				}
			}
			else
			{
				Session::put('langId', Langage::whereInitial(Config::get('app.locale'))->first(['id'])->id);
			}

		}*/
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