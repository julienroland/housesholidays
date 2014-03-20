<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatutsCalendriersTraductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('statuts_calendriers_traductions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom');
			$table->integer('langage_id')->unsigned();
			$table->foreign('langage_id')->references('id')->on('langages');
			$table->integer('statut_calendrier_id')->unsigned();
			$table->foreign('statut_calendrier_id')->references('id')->on('statuts_calendriers');
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
		Schema::drop('statuts_calendriers_traductions');
	}

}
