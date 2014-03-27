<?php

class OptionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('options')->truncate();
		//5 -> equipementExt 
		//32 avec salles -> equipementInt 
		//6  -> literie 
		//3  -> situation geo 
		//[ 46 ]
		$options = array(
		);
		for($i=1; $i <= 46; $i++){

			if( $i >= 1 && $i <=5 ){

				$t = 10;

			}elseif( $i >= 6 && $i <= 37 ){

				$t = 11;

			}elseif( $i >= 38 && $i <= 43 ){

				$t = 12;

			}elseif( $i >= 44 && $i <= 46  ){

				$t = 13;

			}
			array_push($options, array(
				'id'=>$i,
				'type_option_id'=> $t,
				));

		}

		// Uncomment the below to run the seeder
		 DB::table('options')->insert($options);
	}

}
