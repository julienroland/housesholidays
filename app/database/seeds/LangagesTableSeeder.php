<?php

class LangagesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('langages')->truncate();
		$langages = array(
			array(
				'nom'=>'Français',
				'initial'=>'fr'
				),
			array(
				'nom'=>'English',
				'initial'=>'en'
				),
			array(
				'nom'=>'Nederlands',
				'initial'=>'nl'
				),
			array(
				'nom'=>'Deutsch',
				'initial'=>'de'
				),
			array(
				'nom'=>'Spanish',
				'initial'=>'es'
				),
		);

		// Uncomment the below to run the seeder
		DB::table('langages')->insert($langages);
	}

}
