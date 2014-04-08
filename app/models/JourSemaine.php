<?php


class JourSemaine extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'jours_semaines';

	public function tarif(){

		return $this->hasMany('Tarif');

	}

	public function jourSemaineTraduction(){

		return $this->hasMany('jourSemaineTraduction')
		->where(Config::get('var.lang_col'),Session::get('langId'));

	}

	public function tarifSpeciauxWeekend(){

		return $this->belongsToMany('TarifSpeciauxWeekend','jour_semaine_tarif_speciaux_weekend','tarif_weekend_id','jour_semaine_id');
		/*->withPivot('tarif_speciaux_weekend_id')
		->join('tarifs_speciaux_weekends', 'tarif_speciaux_weekend_id', 'tarifs_speciaux_weekends.id');*/

	}
	
	public static function getList( ){

		$joursDump = JourSemaine::with(array('jourSemaineTraduction'=>function( $query ){
			$query->where( Config::get('var.lang_col'), Session::get('langId') );
		}))->get();

		$jours = array(
			'data'=>array(
				''=>Lang::get('form.flexible')),
			
			);

		foreach( $joursDump as $jour ){

			$jours['data'][$jour->id] = $jour->jourSemaineTraduction[0]->nom;

		}

		$jours['count'] = count( $joursDump );
		
		return (object)$jours;
	}

}