<?php

class LocalitesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('localites')->truncate();
		/**
		
			TODO:
			- Trouver et creer le json des villes
			- le parse
		
		**/
		
		/*$data = file_get_contents("./app/database/seeds/cities.json");
		$oData = json_decode($data,true);

		$localites = array();
		$i = 1;
		foreach($oData as $data){


				array_push($localites, array(
					'id'=>$i,
					'pays_id'=>$data["country_id"]));
					'nom'=>$data["country_id"]));

				$i++;

		}*/

		// Uncomment the below to run the seeder
		//DB::table('localites')->insert($localites);
	}

}
