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
		$i = 1;
		$p=1;
		foreach($oData as $data){
			
			foreach($data['regions'] as $region){	

				if(isset($region['subregions'])){
					
					foreach($region['subregions'] as $subregions){

						for($m=0; $m < count($lang); $m++){

							if($lang[$m] === 'en'){

								$nom = $subregions['name'];

								if(isset($region['description'][$lang[$m]])){

									$description = $region['description'][$lang[$m]];

								}else{

									$description = "";
								}

							}else{

								if(isset($subregions['translations'][$lang[$m]]) && !empty($subregions['translations'][$lang[$m]])){

									$nom = $subregions['translations'][$lang[$m]];

								}else{

									$nom = "";
								}
								if(isset($region['description'][$lang[$m]])){

									$description = $region['description'][$lang[$m]];

								}else{

									$description = "";
								}
							}

							array_push($sous_regions_traductions,array('region_id'=>$p));
						}

						
					}
					$p++;
				}
				
			}
			$i++;
		}

		// Uncomment the below to run the seeder
		DB::table('sous_regions')->insert($sous_regions_traductions);
	}

}
