<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocalitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('localites', function(Blueprint $table) {
			$table->increments('id');
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
		Schema::drop('localites');
	}

}
