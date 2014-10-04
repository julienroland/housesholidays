<?php

class LangController extends BaseController {


	public function getAll( ){

		/**
		*
		* Array qui stockera les traductions
		*
		**/
		$langs = array();

		/**
		*
		* @return array
		* Tous les fichiers de langs
		*
		**/

		$langages = File::directories(base_path().'/app/lang/');

		/**
		*
		* Pour chaque ou récupère la [$key] du fichier de la langue en cours
		*
		**/
		foreach( $langages as $key => $langage){

			$ex = explode('/', $langage);

			if(in_array(App::getLocale(), $ex)){

				$pathId = $key;
			}
		}

		/**
		*
		* On chope les traductions
		* @return array [$nom-fichier => $valeur]
		*
		**/

		foreach( File::files($langages[$pathId]) as $key => $files ){

			$ex = explode('/', $files);

			$fileName = explode('.' , $ex[count($ex)-1])[0];


			$langs[$fileName] = File::getRequire( $files );

		}

		/**
		*
		* @return json
		*
		**/
		return json_encode($langs);
	}

	public function change() {

		$input = Input::all();

		Session::put('lang', $input['lang']);

		App::setLocale($input['lang']);

		return Redirect::to('/'.$input['lang']);

	}

}