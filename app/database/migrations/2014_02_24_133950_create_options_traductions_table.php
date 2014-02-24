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
			$table->string('valeur');
			$table->integer('langages_id')->unsigned();
			$table->foreign('langages_id')->references('id')->on('langages');
			$table->integer('options_id')->unsigned();
			$table->foreign('options_id')->references('id')->on('options');
			
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
