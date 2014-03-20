<?php

class TypesBatimentsTraductionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('types_batiments_traductions')->truncate();
		$lang = array('fr','en','nl','de','es');
		$type = array(
			'fr'=> array(
				'agritourisme',
				'Appartement',
				'bateaux',
				'bungalows',
				'camping',
				'chambre d\'hôtes',
				'chateau',
				'condo',
				'gite',
				'hôtel',
				'insolite',
				'maison',
				'mobil-home',
				'villa',
				),
			'en'=> array(
				'farmhouse',
				'Apartment',
				'Boats', 
				'bungalows', 
				'camping', 
				'bed and breakfast',
				'castle', 
				'condo',
				'cottage', 
				'hotel',
				'unusual', 
				'home', 
				'mobile home',
				'villa',
				),
			'nl'=>array(
				'boerenwoning', 
				'appartement',
				'boten', 
				'bungalows', 
				'camping', 
				'gastenkamers',
				'kasteel', 
				'condo', 
				'huisje', 
				'hotel',
				'ongebruikelijk', 
				'thuis', 
				'stacaravan', 
				'villa',
				),
			'de'=>array(
				'Bauernhaus', 
				'Wohnung',
				'Boote', 
				'Bungalows', 
				'camping', 
				'bed and breakfast',
				'Schloss', 
				'Eigentumswohnung', 
				'Hütte', 
				'hotel',
				'ungewöhnlich', 
				'Zuhause', 
				'Wohnwagen', 
				'villa',
				),
			'es'=>array(
				'cortijo', 
				'apartamento',
				'barcos', 
				'Bungalows', 
				'campamento	', 
				'bed and breakfast',
				'castillo', 
				'condominio', 
				'casa de campo ', 
				'hotel',
				'insólito', 
				'casa', 
				'autocaravana', 
				'villa',
				),
			);
		$typesbatimentstraductions = array(

			);
		for($i=0; $i < 14; $i++){

			for($m=0; $m < count($lang); $m++){

				array_push($typesbatimentstraductions,array(
					'nom'=> $type[$lang[$m]][$i], 
					'type_batiment_id'=> $i+1,
					'langage_id'=> $m+1,
					));

			}

		}
		// Uncomment the below to run the seeder
		 DB::table('types_batiments_traductions')->insert($typesbatimentstraductions);
	}

}
