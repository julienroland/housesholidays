<?php

class RoleTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('roles')->truncate();
		$roles = array(
			array(
				'nom'=>'Membre',
				),
			array(
				'nom'=>'Admin',
				),
			array(
				'nom'=>'SuperAdmin',
				),
			);

		// Uncomment the below to run the seeder
		DB::table('roles')->insert($roles);
	}

}
