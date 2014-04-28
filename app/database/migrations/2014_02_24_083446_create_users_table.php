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
			$table->string('fax')->nullable();
			$table->string('adresse')->nullable();
			$table->integer('postal')->nullable();
			$table->string('personne_contact')->nullable();
			$table->string('site_web')->nullable();
			$table->boolean('valide');
			$table->string('key',64)->unique()->nullable();
			//$table->string('fax')->nullable();
			$table->string('password');
			$table->string('slug')->nullable();
			$table->integer('role_id')->unsigned()->nullable();
			$table->foreign('role_id')->references('id')->on('roles');
			$table->integer('maternelle_id')->unsigned()->nullable();
			$table->foreign('maternelle_id')->references('id')->on('langages');
			$table->integer('localite_id')->unsigned()->nullable();
			$table->foreign('localite_id')->references('id')->on('localites');
			$table->integer('pays_id')->unsigned()->nullable();
			$table->foreign('pays_id')->references('id')->on('pays');
			$table->integer('region_id')->unsigned()->nullable();
			$table->foreign('region_id')->references('id')->on('regions');
			$table->integer('sous_region_id')->unsigned()->nullable();
			$table->foreign('sous_region_id')->references('id')->on('sous_regions');
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
