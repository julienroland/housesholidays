<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSousRegionsTraductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sous_regions_traductions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom');
			$table->integer('langages_id')->unsigned();
			$table->foreign('langages_id')->references('id')->on('langages');
			$table->integer('sous_regions_id')->unsigned();
			$table->foreign('sous_regions_id')->references('id')->on('sous_regions');
			
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sous_regions_traductions');
	}

}
