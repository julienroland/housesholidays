<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTelephonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_telephones', function(Blueprint $table) {
			$table->increments('id');
			$table->string('numero');
			$table->string('heure');
			$table->integer('ordre');
			$table->integer('users_id')->unsigned();
			$table->foreign('users_id')->references('id')->on('users');
			
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
		Schema::drop('users_telephones');
	}

}
