<?php

use Carbon\Carbon;


class Helpers {

	public static function isLast( $current, $total ){
		if($current >= $total){
			return true;
		}
		else{
			
			return false;
		}
	}	
	public static function isNotLast( $current, $total ){

		if($current >= $total){
			
			return false;

		}
		else{

			return true;

		}
	}
	public static function isActive( $page, $current ){
		
		if(isset($page) && Helpers::isOk($page) && isset($current) && Helpers::isOk($current)){

			if( $page === $current || $page == $current ){

				return 'class="active"';
			}
		}
	}
	public static function toHumanTimestamp( $timestamp ){

		setlocale(LC_TIME, App::getLocale());  

		return $timestamp->formatLocalized('%e %B %Y %k:%M:%S');
	}
	public static function createCarbonTimestamp( $timestamp, $type='us',  $separator = '-' ){

		Helpers::toHumanTimestamp($timestamp);

	}
	public static function getDateBetween( $start, $end ){
		$dateBetween  = array();
		$start = Helpers::createCarbonDate( $start);
		$end = Helpers::createCarbonDate( $end);

		$diff = $start->diffInDays($end);

		for($a=0;$a <= $diff; $a++){

			array_push($dateBetween , $start->toDateString());

			$start->addDay();
		}

		return $dateBetween;
	}

	public static function build_calendar($month = null, $year = null, $fromId = null , $dateArray = null) {

		if(Helpers::isNotOk( $month )){

			$month = date('n');

		}

		if(Helpers::isNotOk( $year )){

			$year = date('y');
			
		}
		if(Helpers::isOk($fromId)){

			$calendriers = Calendrier::whereProprieteId( $fromId )->get();
			
		}

		$today_date = date("d");
		$today_date = ltrim($today_date, '0');
     // Create array containing abbreviations of days of week.

		$daysOfWeek = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');

     // What is the first day of the month in question?
		$firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
		$numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
		$dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
		$monthName = $dateComponents['month'];
		switch ($monthName) {
			case "January":
			$monthName =  "Janvier";
			break;
			case "February":
			$monthName =  "Février";
			break;
			case "March":
			$monthName =  "Mars";
			break;
			case "April":
			$monthName =  "Avril";
			break;
			case "May":
			$monthName =  "Mai";
			break;
			case "June":
			$monthName =  "Juin";
			break;
			case "July":
			$monthName =  "Juillet";
			break;
			case "August":
			$monthName =  "Août";
			break;
			case "September":
			$monthName =  "Septembre";
			break;
			case "October":
			$monthName =  "Octobre";
			break;
			case "November":
			$monthName =  "Novembre";
			break;
			case "December":
			$monthName =  "Décembre";
			break;
		}
     // What is the index value (0-6) of the first day of the
     // month in question.
		$dayOfWeek = $dateComponents['wday']-1;
		if ($dayOfWeek < 0) {
			$dayOfWeek = 6;
		}
     // Create the table tag opener and day headers

		$calendar = "<table class='calendar'>";
		$calendar .= "<caption>$monthName $year</caption>";
		$calendar .= "<tr>";

     // Create the calendar headers

		foreach($daysOfWeek as $day) {

			$calendar .= "<th class='header'><span class='jour'>$day</span></th>";
		} 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

		$currentDay = 1;

		$calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

		if ($dayOfWeek > 0) {
			for($i = 0;$i<$dayOfWeek;$i++){ 
				// colspan='$dayOfWeek'
				$calendar .= "<td class='day old'>&nbsp;</td>"; 
			}
		}

		$month = str_pad($month, 2, "0", STR_PAD_LEFT);

		foreach($calendriers as $calendrier ){

			$start = $calendrier->date_debut;

			$end = $calendrier->date_fin;

			$listDatesBetween[] = (object)array('id'=>$calendrier->id, 'dates'=>Helpers::getDateBetween( $start, $end ));
			/*var_dump($listDatesBetween);*/
		/*	if($calendrier->date_debut == $serverDate){
				$class='busy';
				$dataId = $calendrier->id;
			}
			else
			{
				$class= '';
				$dataId = '';
			}*/
		}

		while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

			if ($dayOfWeek == 7) {

				$dayOfWeek = 0;
				$calendar .= "</tr><tr>";

			}

			$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);

			
			$date = "$currentDayRel-$month-$year";
			$serverDate = "$year-$month-$currentDayRel";
			$dateCarbon = $serverDate = Helpers::createCarbonDate( $serverDate );

			/*print_r(in_array($serverDate, $listDatesBetween));*/

			$class= '';
			$dataId = '';

			if( isset($listDatesBetween) && Helpers::isOk( $listDatesBetween ) ){

				foreach($listDatesBetween as $datesBetween){
					
					foreach($datesBetween->dates as $dateBetween){

						$dateBetween  = Helpers::createCarbonDate($dateBetween);

						if($dateCarbon->eq($dateBetween)){

							$class='busy';
							$dataId = $datesBetween->id;

						}
					}
				}
			}

			if($currentDayRel == $today_date ){  

				$calendar .= "<td class='day today $class' ><a data-date='$date' data-id='$dataId' data-day='$day' href=''><span class='number'>$currentDay</span>";
			} 

			else { 

				$calendar .= "<td class='day $class' ><a data-date='$date' data-id='$dataId' data-day='$day' href=''><span class='number'>$currentDay</span>"; 
			}

			if(isset($dateArray[mktime(0, 0, 0, $month, $currentDay, $year)])){
				$calendar.=$dateArray[mktime(0, 0, 0, $month, $currentDay, $year)];
			}
			/*foreach($sceances as $sceance){

				if($sceance->date === $date){
					$duree = "h-".substr($sceance->duree, 0, 1);

					$calendar .='<ol class="sceances">';

					$calendar .="<li class='$duree oneSceance' data-cours='$sceance->coursSlug' data-sceance='$sceance->sceancesId'>";
					$calendar .="<span>$sceance->coursNom</span>";

					$calendar .='</li>';

					$calendar .='</ol>';


				}

			}*/
			$calendar.="</a></td>";
          // Increment counters

			$currentDay++;
			$dayOfWeek++;

		}


     // Complete the row of the last week in month, if necessary

		if ($dayOfWeek != 7) { 

			$remainingDays = 7 - $dayOfWeek;
			$calendar .= "<td colspan='$remainingDays'>&nbsp;</td>"; 

		}

		$calendar .= "</tr>";

		$calendar .= "</table>";

		return $calendar;

	}
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
	public static function toSlug( $string, $charset = 'utf-8' ){
		

		$string = htmlentities($string, ENT_NOQUOTES, $charset);
		$string = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $string);
		$string = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $string); 
		$string = preg_replace('#&[^;]+;#', '', $string); 
		$string = strtolower( $string );

		return str_replace(' ' , '-' , $string );

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