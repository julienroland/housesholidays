<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('factures', function(Blueprint $table) {
			$table->increments('id');
			$table->date('date');
			$table->float('prix');
			$table->string('type_paiement');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('propriete_id')->unsigned();
			$table->foreign('propriete_id')->references('id')->on('proprietes');
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
		Schema::drop('factures');
	}

}
