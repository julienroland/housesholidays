<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $fillable = array('nom','prenom','email','password');

	public static $rules = array(
		'prenom'=>'required|min:2|alpha',
		'nom'=>'required|min:2|alpha',
		'email'=>'unique:users,email|email|required', 
		'pays'=>'required',
		'password'=>'required|min:3',
		);

	public static $coordonneRules = array(
		'prenom'=>'required|min:2|alpha|not_in:null',
		'nom'=>'required|min:2|alpha|not_in:null',
		'email'=>'unique:users,email|email|required|not_in:null', 
		'pays'=>'required|not_in:null',
		'sous_region'=>'required|not_in:null',
		'localite'=>'required|not_in:null',
		'adresse'=>'required|not_in:null',
		'postal'=>'required|not_in:null',
		'maternelle'=>'required|not_in:null',
		);

	public static $comm_rules = array(
		'titre'=>'required',
		'date'=>'required',
		'note'=>'required',
		'commentaire'=>'required',
		);

	public static $mess_rules = array(
		'nom'=>'required | alpha',
		'prenom'=>'required | alpha',
		'email'=>'required |email',
		'message'=>'required',
		'sender_id'=>'integer',
		'receiver_id'=>'required |different:sender_id',
		);
	public static $messRep_rules = array(
		'message'=>'required',
		'sender_id'=>'integer',
		'receiver_id'=>'required |different:sender_id',
		'message_id'=>'required',
		);

	public static $sluggable = array(
		'build_from' => 'fullname',
		'save_to'    => 'slug',
		);
	public static function getLangages( $user ){

		$dataDump = $user->langage()->remember(60 * 24)->get()->toArray();
		
		$data = array();

		foreach($dataDump as $datas){

			$data[$datas['id']] = $datas['nom'];
		}

		return $data;
	}
	public function propriete(){

		return $this->hasMany('Propriete');
		
	}

	public function commentaire(){

		return $this->hasMany('Commentaire');
		
	}

	public function messageReceive(){

		return $this->hasMany('Message','vers_user_id')
		->whereNull('reponse_id');
		
	}

	/*public function messageReponse(){

		return $this->hasMany('Message','vers_user_id')
		->whereNotNull('reponse_id');
		
	}*/

	public function messageSend(){

		return $this->hasMany('Message','de_user_id');
		
	}


	public function favoris(){

		return $this->hasMany('Favoris');

	}

	
	public function telephone(){

		return $this->hasMany('UserTelephone');
		
	}

	public function pays(){

		return $this->belongsTo('Pays');
		
	}

	public function langage(){

		return $this->belongsToMany('Langage','users_langages_traductions');
		
	}

	public function getFullnameAttribute() {
		return $this->prenom . ' ' . $this->nom;
	}
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */


	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}