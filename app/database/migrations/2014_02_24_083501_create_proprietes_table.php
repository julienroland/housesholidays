<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProprietesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proprietes', function(Blueprint $table) {
			$table->increments('id');
			$table->tinyInteger('nb_personne');
			$table->float('taille_bien');
			$table->string('video',100)->nullable();
			$table->string('adresse');
			$table->string('latlng')->nullable();
			$table->float('taille_terrain');
			$table->integer('annonces_payees_id')->unsigned();
			$table->foreign('annonces_payees_id')->references('id')->on('annonces_payees');
			$table->boolean('statut');
			$table->float('caution')->nullable();
			$table->integer('nb_visite');
			$table->string('slug');
			$table->boolean('commentaire_statut');
			$table->integer('users_id')->unsigned();
			$table->foreign('users_id')->references('id')->on('users');
			$table->string('orientation_vue',50);
			$table->tinyInteger('etage');
			$table->text('conditions_paiement')->nullable();
			$table->text('note_paiement')->nullable();
			$table->integer('localites_id')->unsigned();
			$table->foreign('localites_id')->references('id')->on('localites');
			$table->string('titre');
			$table->integer('pays_id')->unsigned();
			$table->foreign('pays_id')->references('id')->on('pays');
			$table->integer('regions_id')->unsigned();
			$table->foreign('regions_id')->references('id')->on('regions');
			$table->integer('sous_regions')->unsigned();
			$table->foreign('sous_regions')->references('id')->on('sous_regions');
			$table->integer('types_batiments_id')->unsigned();
			$table->foreign('types_batiments_id')->references('id')->on('types_batiments');


			
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
		Schema::drop('proprietes');
	}

}
