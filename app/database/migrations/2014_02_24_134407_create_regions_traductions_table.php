<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegionsTraductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('regions_traductions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom');
			$table->text('description');
			$table->integer('langage_id')->unsigned();
			$table->foreign('langage_id')->references('id')->on('langages');
			$table->integer('region_id')->unsigned();
			$table->foreign('region_id')->references('id')->on('regions');
			
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
		Schema::drop('region_traductions');
	}

}
