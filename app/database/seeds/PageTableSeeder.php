<?php

class PageTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		
		$page = array(

			'id'=>1,
			'hook'=>'login',
			'statut'=>1,

			);

		// Uncomment the below to run the seeder
		DB::table('pages')->insert($page);
	}

}
