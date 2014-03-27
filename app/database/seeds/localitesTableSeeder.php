<?php

class LocalitesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('localites')->truncate();
		

		
		$data = file_get_contents("./app/database/seeds/cities.json");
		$oData = json_decode($data,true);

		$localites = array();

		foreach($oData as $data){


				array_push($localites, array(
					'id'=>$data['id'],
					'pays_id'=> (int)$data["country_id"],
					'nom'=> $data["name"],
					));

		}

		// Uncomment the below to run the seeder
		DB::table('localites')->insert($localites);
	}

}
