<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaysTraductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pays_traductions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom');
			$table->integer('langage_id')->unsigned()->nullable();
			$table->foreign('langage_id')->references('id')->on('langages')->onDelete('cascade');
			$table->integer('pays_id')->unsigned();
			$table->foreign('pays_id')->references('id')->on('pays')->onDelete('cascade');
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pays_traductions');
	}

}
