<?php



class JourSemaineTableSeeder extends Seeder {

	public function run()
	{
		$jour_semaine = array();
		
		for($i = 1; $i < 8; $i++){

			array_push( $jour_semaine, array('id'=>$i));

		}

		// Uncomment the below to run the seeder
		DB::table('jours_semaines')->insert($jour_semaine);
	}

}