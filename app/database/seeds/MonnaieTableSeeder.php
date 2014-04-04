<?php

class MonnaieTableSeeder extends Seeder {

	public function run()
	{
		$options = array(
			array(
				'nom'=>'Euro',
				'initial'=>'Euro',
				'icon'=>'€',
				),
			array(
				'nom'=>'Livre sterling',
				'initial'=>'Livre',
				'icon'=>'£',
				),
				array(
				'nom'=>'Dollars USA',
				'initial'=>'Dollars',
				'icon'=>'$',
				),
				array(
				'nom'=>'Perso Argentin',
				'initial'=>'Peso',
				'icon'=>'$',
				),
				array(
				'nom'=>'Franc Suisse',
				'initial'=>'CHF',
				'icon'=>'Fr',
				),
			);

		// Uncomment the below to run the seeder
		DB::table('monnaies')->insert($options);
	}

}