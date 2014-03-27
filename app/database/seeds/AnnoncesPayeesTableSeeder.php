<?php

class AnnoncesPayeesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('annoncespayees')->truncate();

		$annoncespayees = array(
			array(
				"paiement_statut_id" => 1,
				"nom" => "non-paye"
				),
			array(
				"paiement_statut_id" => 2,
				"nom" => "attente"
				),
			array(
				"paiement_statut_id" => 3,
				"nom" => "reçus",
				),
			);

		// Uncomment the below to run the seeder
		 DB::table('annonces_payees')->insert($annoncespayees);
	}

}
