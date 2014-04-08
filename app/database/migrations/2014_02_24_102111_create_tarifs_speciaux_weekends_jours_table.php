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
		Schema::create('jour_semaine_tarif_speciaux_weekend', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('tarif_weekend_id')->unsigned(); 
			$table->foreign('tarif_weekend_id')->references('id')->on('tarifs_speciaux_weekends');
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
		Schema::drop('jour_semaine_tarif_speciaux_weekend');
	}

}
