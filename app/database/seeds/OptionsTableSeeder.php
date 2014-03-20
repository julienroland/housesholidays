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

				$t = 12;

			}elseif( $i >= 6 && $i <= 32 ){

				$t = 13;

			}elseif( $i >= 33 && $i <= 40 ){

				$t = 14;

			}elseif( $i >= 41 && $i <= 44  ){

				$t = 15;

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
