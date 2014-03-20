<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOptionsTraductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('options_traductions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('cle');
			$table->string('valeur')->nullable();
			$table->integer('langage_id')->unsigned();
			$table->foreign('langage_id')->references('id')->on('langages');
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
		Schema::drop('options_traductions');
	}

}
