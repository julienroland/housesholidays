<?php


class TypeOption extends Eloquent {

	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'types_options';

	public function option(){

		return $this->hasMany('Option');

	}

	public function parent(){
		/*if($this->parent_id !== null && $this->parent_id > 0){*/
			return $this->belongsTo('TypeOption','parent_id');
			/*z*/

		}
		public function enfant() {
			return $this->hasMany('TypeOption', 'parent_id')->with(array('enfant.option.optionTraduction'=>function($query){

				$query->where(Config::get('var.lang_col'),Session::get('langId'));
				
			}
			)); 
		}


	}