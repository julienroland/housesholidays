<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table) {
			$table->increments('id');
			$table->string('titre');
			$table->text('texte');
			$table->date('date');
			$table->integer('de_users_id')->unsigned();
			$table->foreign('de_users_id')->references('id')->on('users');
			$table->integer('vers_users_id')->unsigned();
			$table->foreign('vers_users_id')->references('id')->on('users');
			$table->integer('reponse_id')->unsigned();
			$table->foreign('reponse_id')->references('id')->on('messages');
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
		Schema::drop('messages');
	}

}
