<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::statement('SET foreign_key_checks = 0');
		DB::statement('SET UNIQUE_CHECKS=0');

		/*$this->call('PaysTableSeeder');
		$this->call('PaysTraductionsTableSeeder');
		$this->call('RegionsTraductionsTableSeeder');
		$this->call('LangagesTableSeeder');
		$this->call('LocalitesTableSeeder');
		$this->call('RegionsTableSeeder');
		$this->call('SousRegionsTableSeeder');
		$this->call('SousRegionTraductionsTableSeeder');
		$this->call('TypesBatimentsTableSeeder');
		$this->call('TypesBatimentsTraductionsTableSeeder');
		$this->call('TypesOptionsTableSeeder');
		$this->call('OptionsTableSeeder');
		$this->call('OptionsTraductionsTableSeeder');
		$this->call('AnnoncesPayeesTableSeeder');
		$this->call('PaiementsStatutsTableSeeder');
		$this->call('MonnaieTableSeeder');
		$this->call('JourSemaineTableSeeder');
		$this->call('JourSemaineTraductionTableSeeder');
		$this->call('ImagesTypesTableSeeder');
		$this->call('PageTableSeeder');*/
		$this->call('PageTraductionTableSeeder');

		
		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');	
		
		
		
		
	}

}