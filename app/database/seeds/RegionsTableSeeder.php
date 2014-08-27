<?php

class RegionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('regions')->truncate();
		$data = file_get_contents("./app/database/seeds/regions.json");
		$oData = json_decode($data,true);
		$lang = array('fr','en','nl','de','es');
		$regions = array();
		$i = 1;
		foreach($oData as $data){

			foreach($data['regions'] as $region){	

				if(isset($region["coords"])){

					$coords = $region["coords"];

				}else{

					$coords = null;

				}

				array_push($regions, array(
					'id'=>$i,
					'statut'=>1,
					'coords'=>$coords,
					'pays_id'=>$data["country_id"]));

				$i++;
			}
		}

		// Uncomment the below to run the seeder
		DB::table('regions')->insert($regions);
	}

}
