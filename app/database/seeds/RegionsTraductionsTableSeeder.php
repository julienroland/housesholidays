<?php

class RegionsTraductionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('regionstraductions')->truncate();

		$data = file_get_contents("./app/database/seeds/regions.json");
		$oData = json_decode($data,true);
		$lang = array('fr','en','nl','de','es');
		$regions_traductions = array();
		$i = 1;
		foreach($oData as $data){
			
			foreach($data['regions'] as $data){		

				for($m=0; $m < count($lang); $m++){

					if($lang[$m] === 'en'){

						$langage = $data['name'];

					}else{

						if(isset($data['translations'][$lang[$m]]) && !empty($data['translations'][$lang[$m]])){

							$langage = $data['translations'][$lang[$m]];

						}else{

							$langage = "";
						}
					}

					array_push($regions_traductions,['nom'=>$langage, 'region_id'=>$i, 'langage_id'=>$m+1]);
				}
				$i++;
			}
		}
		

		// Uncomment the below to run the seeder
		DB::table('regions_traductions')->insert($regions_traductions);
	}

}
