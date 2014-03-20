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
			$table->string('condition_paiement');
			$table->integer('propriete_id')->unsigned();
			$table->foreign('propriete_id')->references('id')->on('proprietes');
			$table->integer('langage_id')->unsigned();
			$table->foreign('langage_id')->references('id')->on('langages');
			
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
