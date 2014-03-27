<?php

class TypesOptionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('types_options')->truncate();

		$typesoptions = array(
			array(
				'id' => 1,
				'nom'=>'batiment',
				'parent_id'=> null,
				),
			array(
				'id' => 2,
				'nom'=>'etape_1',
				'parent_id'=> 1,
				),
			array(
				'id' => 3,
				'nom'=>'etape_2',
				'parent_id'=> 1,
				),
			array(
				'id' => 4,
				'nom'=>'etape_3',
				'parent_id'=> 1,
				),
			array(
				'id' => 5,
				'nom'=>'etape_4',
				'parent_id'=> 1,
				),
			array(
				'id' => 6,
				'nom'=>'etape_5',
				'parent_id'=> 1,
				),
			array(
				'id' => 7,
				'nom'=>'etape_6',
				'parent_id'=> 1,
				),
			array(
				'id' => 8,
				'nom'=>'etape_7',
				'parent_id'=> 1,
				),
			array(
				'id' => 9,
				'nom'=>'etape_8',
				'parent_id'=> 1,
				),
			array(
				'id'=> 10,
				'nom' =>'b_exterieur',
				'parent_id'=> 3,
				),
			array(
				'id'=> 11,
				'nom' =>'b_interieur',
				'parent_id'=> 3,
				),
			array(
				'id'=> 12,
				'nom' =>'b_literie',
				'parent_id'=> 3,
				),
			array(
				'id'=> 13,
				'nom' =>'b_situation_geographique',
				'parent_id'=> 4,
				));

		// Uncomment the below to run the seeder
DB::table('types_options')->insert($typesoptions);
}

}
