<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pays', function(Blueprint $table) {
			$table->increments('id')->unique();
			$table->string('initial_2',10);
			$table->string('initial_3',10)->nullable();
			$table->string('code_telephone',50)->nullable();
			$table->string('extension_domaine')->nullable();
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pays');
	}

}
