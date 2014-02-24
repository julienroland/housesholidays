<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJoursSemainesTraductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jours_semaines_traductions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom');
			$table->integer('langages_id')->unsigned();
			$table->foreign('langages_id')->references('id')->on('langages');
			$table->integer('jours_semaines_id')->unsigned();
			$table->foreign('jours_semaines_id')->references('id')->on('jours_semaines');
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
		Schema::drop('jours_semaines_traductions');
	}

}
