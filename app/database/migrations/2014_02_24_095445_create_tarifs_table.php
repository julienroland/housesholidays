<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTarifsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tarifs', function(Blueprint $table) {
			$table->increments('id');
			$table->date('date_debut');
			$table->date('date_fin');
			$table->tinyInteger('duree_min');
			$table->string('saison');
			$table->float('prix_nuit');
			$table->float('prix_semaine');
			$table->float('prix_mois');
			$table->boolean('disponibilite');
			$table->float('prix-weekend');
			$table->integer('jour_arrive_id')->unsigned();
			$table->foreign('jour_arrive_id')->references('id')->on('jours_semaines');
			$table->integer('tarifs_speciaux_weekends_id')->unsigned();
			$table->foreign('tarifs_speciaux_weekends_id')->references('id')->on('tarifs_speciaux_weekends');
			$table->integer('monnaies_id')->unsigned();
			$table->foreign('monnaies_id')->references('id')->on('monnaies');
			$table->integer('proprietes_id')->unsigned();
			$table->foreign('proprietes_id')->references('id')->on('proprietes');

			
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
		Schema::drop('tarifs');
	}

}
