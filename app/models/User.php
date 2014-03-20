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
		'prenom'=>'required|min:2',
		'nom'=>'required|min:2',
		'email'=>'email|required', //unique:users,email|
		'pays'=>'required',
		'password'=>'required|min:3',
		);

	public static $sluggable = array(
		'build_from' => 'fullname',
		'save_to'    => 'slug',
		);

	public function pays(){

		return $this->belongsTo('Pays');
		
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