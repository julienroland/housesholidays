<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTarifsSpeciauxWeekendsJoursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tarifs_speciaux_weekends_jours', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('tarifs_id')->unsigned();
			$table->foreign('tarifs_id')->references('id')->on('tarifs_speciaux_weekends');
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
		Schema::drop('tarifs_speciaux_weekends_jours_semaines');
	}

}
