<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnnoncesPayeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('annonces_payees', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom');
			$table->integer('paiement_statut_id')->unsigned();
			$table->foreign('paiement_statut_id')->references('id')->on('paiements_statuts');
			
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
		Schema::drop('annonces_payees');
	}

}
