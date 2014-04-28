<?php

class OptionsTraductionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('optionstraductions')->truncate();
		//5 -> equipementExt 
		//32 avec salles -> equipementInt 
		//6  -> literie 
		//3  -> situation geo 
		//[ 46 ]
		$lang = array('fr','en','nl','de','es');

		$options = array(

			'fr'=>array(

				array(

					'key' => 'mobilier-jardin',
					'valeur' => 'Mobilier de jardin',

					),
				array(

					'key' => 'bbq',
					'valeur' => 'BBQ',
					

					),
				array(

					'key' => 'transat',
					'valeur' => 'Transat',
					

					),
				array(

					'key' => 'ping-pong',
					'valeur' => 'Ping-pong',
					

					),
				array(

					'key' => 'jeux-enfants',
					'valeur' => 'Jeux pour enfants',
					

					),
				//
				array(

					'key' => 'cuisine-independante',
					'valeur' => 'Cuisine indépendante',
					

					),
				array(

					'key' => 'cuisine-americaine',
					'valeur' => 'Cuisine américaine',
					
					),
				array(
					'key' => 'kitchenette',
					'valeur' => 'Kitchenette',
					
					),
				array(
					'key' => 'salle-manger',
					'valeur' => 'Salle à manger',
					
					),
				array(
					'key' => 'salon',
					'valeur' => 'Salon',
					
					),
				array(
					'key' => 'mezzanine',
					'valeur' => 'Mezzanine',
					
					),
				array(
					'key' => 'lodge',
					'valeur' => 'Lodge',
					
					),
				array(
					'key' => 'debarras',
					'valeur' => 'Débarras',
					
					),
				array(
					'key' => 'coin-cabine',
					'valeur' => 'Coin cabine',
					
					),
				array(
					'key' => 'balcon',
					'valeur' => 'Balcon',
					
					),
				array(
					'key' => 'terrasse',
					'valeur' => 'Terrasse',
					
					),
				array(
					'key' => 'veranda',
					'valeur' => 'Véranda',
					
					),
				array(
					'key' => 'cour',
					'valeur' => 'Cour',
					
					),
				array(
					'key' => 'jardin',
					'valeur' => 'Jardin',
					
					),
				array(
					'key' => 'garage',
					'valeur' => 'Garage',
					
					),
				array(
					'key' => 'salle-de-jeux',
					'valeur' => 'Salle de jeux',
					
					),
				array(
					'key' => 'local-skis',
					'valeur' => 'Local à skis',
					
					),
				array(
					'key' => 'parking-prive',
					'valeur' => 'Parking privé',
					
					),
				array(
					'key' => 'parking-commun',
					'valeur' => 'Parking commun',
					
					),
				array(
					'key' => 'piscine-privee',
					'valeur' => 'Piscine privée',
					
					),
				array(
					'key' => 'piscine-commune',
					'valeur' => 'Piscine commune',
					
					),
				array(
					'key' => 'tennis-prive',
					'valeur' => 'Tennis privé',
					
					),
				array(
					'key' => 'court-tennis-commun',
					'valeur' => 'Court de tennis commun',
					
					),
				array(
					'key' => 'terrain-petanque',
					'valeur' => 'Terrain de pétanque',
					
					),
				array(
					'key' => 'draps-fournis',
					'valeur' => 'Draps fournis',
					
					),
				array(
					'key' =>'linge-toilette-fournis',
					'valeur' =>'Linge de toilette fournis',
					
					),
				array(
					'key' => 'location-de-linge',
					'valeur' => 'Location de linge',
					
					),
				array(
					'key' => 'petit-dejeuner-inclus',
					'valeur' => 'petit-dejeuner-inclus',
					
					),
				array(
					'key' => 'jardinier',
					'valeur' => 'Jardinier',
					
					),
				array(
					'key' => 'salles-eau',
					'valeur' => 'Salles d\'eau',
					
					),
				array(
					'key' => 'nb-db',
					'valeur' => 'salles de bains',
					
					),
				array(
					'key' => 'nb-wc',
					'valeur' => 'WC',
					
					),
				//
				array(
					'key' => 'nb-chambres',
					'valeur' => 'chambres',
					
					),
				array(
					'key' => 'nb-lits-doubles',
					'valeur' => 'lits doubles',
					
					),
				array(
					'key' => 'nb-de-lit-enfant',
					'valeur' => 'lit enfant',
					
					),
				array(
					'key' =>'nb-de-couchages',
					'valeur' =>'couchages',
					
					),
				array(
					'key' => 'nb-de-lits-simples',
					'valeur' => 'lits simples',
					
					),
				array(
					'key' => 'nb-de-canape-lit',
					'valeur' => 'canapé-lit',
					
					),
				//
				array(
					array(
						'key' => 'situation',
						'valeur' => 'Mer',
						),
					array(
						'key' => 'situation',
						'valeur' => 'Campagne',
						),
					array(
						'key' => 'situation',
						'valeur' => 'Montagne',
						),
					array(
						'key' => 'situation',
						'valeur' => 'Ville',
						),
					),
				array(
					'key' => 'distance',
					'valeur' => 'Distance',
					
					),
				array(
					'key' => 'region-touristique',
					'valeur' => 'Région touristique',
					
					),

				),
				/**
				*
				* EN
				*
				**/
				
				'en' => array(

					array(

					'key' => 'mobilier-jardin',
					'valeur' => 'Garden Furniture',

					),
				array(

					'key' => 'bbq',
					'valeur' => 'BBQ',
					

					),
				array(

					'key' => 'transat',
					'valeur' => 'Transat',
					

					),
				array(

					'key' => 'ping-pong',
					'valeur' => 'Ping-pong',
					

					),
				array(

					'key' => 'jeux-enfants',
					'valeur' => 'Playground',
					

					),
				//
				array(

					'key' => 'cuisine-independante',
					'valeur' => 'Independent Kitchen',
					

					),
				array(

					'key' => 'cuisine-americaine',
					'valeur' => 'American kitchen',
					
					),
				array(
					'key' => 'kitchenette',
					'valeur' => 'Kitchenette',
					
					),
				array(
					'key' => 'salle-manger',
					'valeur' => 'Dining',
					
					),
				array(
					'key' => 'salon',
					'valeur' => 'Show',
					
					),
				array(
					'key' => 'mezzanine',
					'valeur' => 'Mezzanine',
					
					),
				array(
					'key' => 'lodge',
					'valeur' => 'Lodge',
					
					),
				array(
					'key' => 'debarras',
					'valeur' => 'Junk',
					
					),
				array(
					'key' => 'coin-cabine',
					'valeur' => 'Cabine',
					
					),
				array(
					'key' => 'balcon',
					'valeur' => 'Balcony',
					
					),
				array(
					'key' => 'terrasse',
					'valeur' => 'Terrace',
					
					),
				array(
					'key' => 'veranda',
					'valeur' => 'Veranda',
					
					),
				array(
					'key' => 'cour',
					'valeur' => 'Court',
					
					),
				array(
					'key' => 'jardin',
					'valeur' => 'Garden',
					
					),
				array(
					'key' => 'garage',
					'valeur' => 'Garage',
					
					),
				array(
					'key' => 'salle-de-jeux',
					'valeur' => 'Playroom',
					
					),
				array(
					'key' => 'local-skis',
					'valeur' => 'Ski local',
					
					),
				array(
					'key' => 'parking-prive',
					'valeur' => 'Private Parking',
					
					),
				array(
					'key' => 'parking-commun',
					'valeur' => 'Common Parking',
					
					),
				array(
					'key' => 'piscine-privee',
					'valeur' => 'Private Pool',
					
					),
				array(
					'key' => 'piscine-commune',
					'valeur' => 'communal pool',
					
					),
				array(
					'key' => 'tennis-prive',
					'valeur' => 'Tennis private',
					
					),
				array(
					'key' => 'court-tennis-commun',
					'valeur' => 'Tennis common',
					
					),
				array(
					'key' => 'terrain-petanque',
					'valeur' => 'Boules',
					
					),
				array(
					'key' => 'draps-fournis',
					'valeur' => 'linen provided',
					
					),
				array(
					'key' =>'linge-toilette-fournis',
					'valeur' =>'Towels provided',
					
					),
				array(
					'key' => 'location-de-linge',
					'valeur' => 'Linen hire',
					
					),
				array(
					'key' => 'petit-dejeuner-inclus',
					'valeur' => 'breakfast room included',
					
					),
				array(
					'key' => 'jardinier',
					'valeur' => 'Gardener',
					
					),
				array(
					'key' => 'salles-eau',
					'valeur' => 'Full water',
					
					),
				array(
					'key' => 'nb-db',
					'valeur' => 'Number of bathrooms',
					
					),
				array(
					'key' => 'nb-wc',
					'valeur' => ' Number of toilets',
					
					),
				//
				array(
					'key' => 'nb-chambres',
					'valeur' => ' Number of rooms',
					
					),
				array(
					'key' => 'nb-lits-doubles',
					'valeur' => 'Number of double beds',
					
					),
				array(
					'key' => 'nb-de-lit-enfant',
					'valeur' => 'Number of cot',
					
					),
				array(
					'key' =>'nb-de-couchages',
					'valeur' =>'Sleeps',
					
					),
				array(
					'key' => 'nb-de-lits-simples',
					'valeur' => 'Number of single beds',
					
					),
				array(
					'key' => 'nb-de-canape-lit',
					'valeur' => 'Number of sofa- bed',
					
					),
				//
				array(
					array(
						'key' => 'situation',
						'valeur' => 'Sea',
						),
					array(
						'key' => 'situation',
						'valeur' => 'Country',
						),
					array(
						'key' => 'situation',
						'valeur' => 'Mountain',
						),
					array(
						'key' => 'situation',
						'valeur' => 'City',
						),
					),
				array(
					'key' => 'distance',
					'valeur' => 'Distance',
					
					),
				array(
					'key' => 'region-touristique',
					'valeur' => 'Tourist',
					
					),
				),
);

$optionstraductions = array(

	);
for($i=1; $i <= 46; $i++){

	for($m=0; $m < count($lang); $m++){
		if(isset($options[$lang[$m]])){
			if(isset($options[$lang[$m]][$i-1][0]['key']))
			{
				for($d=0; $d < count($options[$lang[$m]][$i-1]); $d++){
					array_push($optionstraductions, array(
						'cle'=>$options[$lang[$m]][$i-1][$d]['key'],
						'valeur'=>$options[$lang[$m]][$i-1][$d]['valeur'],
						'option_id'=>$i,
						'langage_id'=>$m+1
						));
				}
			}
			else
			{
				array_push($optionstraductions, array(
					'cle'=>$options[$lang[$m]][$i-1]['key'],
					'valeur'=>$options[$lang[$m]][$i-1]['valeur'],
					'option_id'=>$i,
					'langage_id'=>$m+1
					));
			}
		}
	}
}
		// Uncomment the below to run the seeder
DB::table('options_traductions')->insert($optionstraductions);
}

}
