<?php


class ImagesTypesTableSeeder extends Seeder {

	public function run()
	{
// Uncomment the below to wipe the table clean before populating
		// DB::table('langages')->truncate();
		$image_type = array(
			array(
				'nom'=>'small',
				'width'=>'100',
				'height'=>'75',
				'extension'=>'jpg',
				),
			array(
				'nom'=>'medium',
				'width'=>'362',
				'height'=>'272',
				'extension'=>'jpg',
				),
			array(
				'nom'=>'lightbox',
				'width'=>'1024',
				'height'=>'768',
				'extension'=>'jpg',
				),
			);

		// Uncomment the below to run the seeder
		DB::table('images_types')->insert($image_type);
	}

}