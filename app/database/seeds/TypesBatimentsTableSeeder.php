<?php

class TypesBatimentsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('types_batiments')->truncate();

		$typesbatiments = array(
		);
		for($i=0; $i < 14; $i++){
			array_push($typesbatiments, array( 'id'=> $i+1));
		}

		// Uncomment the below to run the seeder
		 DB::table('types_batiments')->insert($typesbatiments);
	}

}
