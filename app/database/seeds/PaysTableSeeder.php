<?php

class PaysTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('pays')->truncate();
		$data = file_get_contents("./app/database/seeds/countries.json");
		$oData = json_decode($data);

	$pays = array();

	for($i=0; $i < count($oData) ;$i++){

		array_push($pays,
			array('initial_2'=>$oData[$i]->cca2, 
				'initial_3'=>$oData[$i]->cca3,
				'code_telephone'=>$oData[$i]->callingCode[0],
				'extension_domaine'=>$oData[$i]->tld[0]));

		}
		
		// Uncomment the below to run the seeder
		DB::table('pays')->insert($pays);
	}

}
