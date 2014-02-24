<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom');
			$table->string('prenom');
			$table->string('email');
			$table->string('adresse');
			$table->integer('postal');
			$table->string('fax')->nullable();
			$table->string('password');
			$table->string('web');
			$table->string('slug');
			$table->integer('maternelle_id')->unsigned();
			$table->foreign('maternelle_id')->references('id')->on('langages');
			$table->integer('localites_id')->unsigned();
			$table->foreign('localites_id')->references('id')->on('localites');
			$table->integer('pays_id')->unsigned();
			$table->foreign('pays_id')->references('id')->on('pays');
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
		Schema::drop('users');
	}

}
