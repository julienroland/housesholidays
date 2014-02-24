<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTop10Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('top10', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('proprietes_id')->unsigned();
			$table->foreign('proprietes_id')->references('id')->on('proprietes');
			
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
		Schema::drop('top10');
	}

}
