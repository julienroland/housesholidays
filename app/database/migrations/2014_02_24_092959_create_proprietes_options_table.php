<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProprietesOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proprietes_options', function(Blueprint $table) {
			$table->increments('id');
			$table->string('valeur');
			$table->integer('propriete_id')->unsigned();
			$table->foreign('propriete_id')->references('id')->on('proprietes');
			$table->integer('option_id')->unsigned();
			$table->foreign('option_id')->references('id')->on('options');
			
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
		Schema::drop('proprietes_options');
	}

}
