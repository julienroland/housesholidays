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
			$table->tinyInteger('nb_chambre');
			$table->tinyInteger('nb_sdb');
			$table->float('taille_bien');
			$table->string('video',100)->nullable();
			$table->string('adresse');
			$table->string('latlng')->nullable();
			$table->float('taille_terrain');
			$table->integer('annonce_payee_id')->unsigned()->nullable();
			$table->foreign('annonce_payee_id')->references('id')->on('annonces_payees');
			$table->boolean('statut');
			$table->float('caution')->nullable();
			$table->integer('nb_visite');
			$table->string('slug');
			$table->string('web');
			$table->string('etape');
			$table->float('nettoyage');
			$table->boolean('commentaire_statut');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('orientation_vue',50);
			$table->tinyInteger('etage');
			$table->text('condition_paiement')->nullable();
			$table->text('note_paiement')->nullable();
			$table->integer('localite_id')->unsigned()->nullable();
			$table->foreign('localite_id')->references('id')->on('localites');
			$table->string('nom');
			$table->integer('pays_id')->unsigned()->nullable();
			$table->foreign('pays_id')->references('id')->on('pays');
			$table->integer('region_id')->unsigned()->nullable();
			$table->foreign('region_id')->references('id')->on('regions');
			$table->integer('sous_region_id')->unsigned()->nullable();
			$table->foreign('sous_region_id')->references('id')->on('sous_regions');
			$table->integer('type_batiment_id')->unsigned();
			$table->foreign('type_batiment_id')->references('id')->on('types_batiments');

			
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
