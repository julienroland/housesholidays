<?php

class PaiementsStatutsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('paiementsstatuts')->truncate();

		$paiementsstatuts = array(

			array(
				"id" => 1,
				"nom" => "non-paye"
				),
			array(
				"id" => 2,
				"nom" => "attente"
				),
			array(
				"id" => 3,
				"nom" => "reçus",
				),

		);

		// Uncomment the below to run the seeder
		DB::table('paiements_statuts')->insert($paiementsstatuts);
	}

}
