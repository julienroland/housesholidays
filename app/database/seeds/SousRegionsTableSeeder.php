<?php

class SousRegionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('sous_regions')->truncate();

		$data = file_get_contents("./app/database/seeds/regions.json");
		$oData = json_decode($data,true);

		$lang = array('fr','en','nl','de','es');
		$sous_regions_traductions = array();
		$p=1;
		foreach($oData as $data){

			foreach($data['regions'] as $region){	
				
				if(isset($region['subregions'])){
					
					foreach($region['subregions'] as $subregions){

							array_push($sous_regions_traductions,array('region_id'=>$p,'statut'=>1));

					}//end foreach subregion
					$p++;

				}//endif

			}//end foreach
		}

		// Uncomment the below to run the seeder
		DB::table('sous_regions')->insert($sous_regions_traductions);
	}

}
