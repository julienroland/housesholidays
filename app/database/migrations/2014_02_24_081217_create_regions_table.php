<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('regions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('nb_vue');
			$table->boolean('statut');
			$table->string('coords')->nullable();
			$table->integer('pays_id')->unsigned();
			$table->foreign('pays_id')->references('id')->on('pays');
			
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
		Schema::drop('regions');
	}

}
