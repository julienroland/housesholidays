<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProprietesTraductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proprietes_traductions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('cle');
			$table->string('valeur');
			$table->string('conditions_paiement');
			$table->integer('proprietes_id')->unsigned();
			$table->foreign('proprietes_id')->references('id')->on('proprietes');
			$table->integer('langages_id')->unsigned();
			$table->foreign('langages_id')->references('id')->on('langages');
			
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
		Schema::drop('proprietes_traductions');
	}

}
