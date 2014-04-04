<?php

class JourSemaineTraductionTableSeeder extends Seeder {

	public function run()
	{
		$lang = array('fr','en','nl','de','es');
		$jour = array(

			'fr'=>array(
				'Lundi',
				'Mardi',
				'Mercredi',
				'Jeudi',
				'Vendredi',
				'Samedi',
				'Dimanche',
				),

			'en'=>array(
				'Monday',
				'Tuesday',
				'Wednesday',
				'Thursday',
				'Friday',
				'Saturday',
				'Sunday',
				),

			'nl'=>array(
				'Maandag',
				'Dinsdag',
				'Woensdag',
				'Donderdag',
				'Vrijdag',
				'Zaterdag',
				'Zondag',
				),

			'de'=>array(
				'Montag',
				'Dienstag',
				'Mittwoch',
				'Donnerstag',
				'Freitag',
				'Samstag',
				'Sonntag',

				),

			'es'=>array(
				'Lunes',
				'Martes',
				'Miércoles',
				'Jueves',
				'Viernes',
				'Sábado',
				'Domingo',

				),
			);
		$jour_semaine = array();
		
		for($i = 0; $i < 7; $i++){
			for($m = 0; $m < count($lang); $m++){

				array_push( $jour_semaine, 
					array(
					'nom'=>$jour[$lang[$m]][$i],
					'jour_semaine_id'=>$i+1,
					'langage_id'=>$m+1,
					));

			}

		}
		
		// Uncomment the below to run the seeder
		DB::table('jours_semaines_traductions')->insert($jour_semaine);
	}

}