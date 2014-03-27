<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhotosProprietesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('photo_propriete', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('propriete_id')->unsigned();
			$table->foreign('propriete_id')->references('id')->on('proprietes');
			$table->string('url');
			$table->tinyInteger('ordre');
			$table->boolean('accroche');
			
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
		Schema::drop('photo_propriete');
	}

}
