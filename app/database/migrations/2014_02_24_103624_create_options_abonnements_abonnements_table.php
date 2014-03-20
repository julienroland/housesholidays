<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOptionsAbonnementsAbonnementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('options_abonnements_abonnements', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('abonnement_id')->unsigned();
			$table->foreign('abonnement_id')->references('id')->on('abonnements');
			$table->integer('option_abonnement_id')->unsigned();
			$table->foreign('option_abonnement_id')->references('id')->on('options_abonnements');
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
		Schema::drop('options_abonnements_abonnements');
	}

}
