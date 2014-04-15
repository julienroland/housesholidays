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
			$table->string('nom');
			$table->boolean('statut');
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
		Schema::drop('localites');
	}

}
