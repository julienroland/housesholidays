<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTypesBatimentsTraductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('types_batiments_traductions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom');
			$table->integer('type_batiment_id')->unsigned();
			$table->foreign('type_batiment_id')->references('id')->on('types_batiments');
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
		Schema::drop('types_batiments_traductions');
	}

}
