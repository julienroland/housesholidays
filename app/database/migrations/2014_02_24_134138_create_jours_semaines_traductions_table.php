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
			$table->integer('langage_id')->unsigned();
			$table->foreign('langage_id')->references('id')->on('langages');
			$table->integer('jour_semaine_id')->unsigned();
			$table->foreign('jour_semaine_id')->references('id')->on('jours_semaines');
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
