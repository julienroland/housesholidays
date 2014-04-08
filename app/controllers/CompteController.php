<?php

class CompteController extends BaseController {

	public function index() {

        $nbInscriptionProprietePasFinie = User::find(Auth::user()->id)->propriete()->whereNotIn('etape',array('8',"","1"))->count();

        return View::make('compte.index')
        ->with(compact('nbInscriptionProprietePasFinie'));
    }

    public function listInscriptionIncomplete(  ){

        //todo afficher la liste des locations pas finie, voir requete au dessus
        $user = User::find( Auth::user()->id );

        $proprietesDump = $user
        ->propriete(  )
        ->with(array('proprieteTraduction'=>function($query){

            $query->where(Config::get('var.lang_col'),Session::get('langId'));

        }))
        ->where( 'etape','!=','8' )
        ->where( 'etape','!=','' )
        ->get(  );

        $data = array(
            'data'=>array(
                ),
            );

        foreach( $proprietesDump as $propriete ){
            dd($propriete);

            $propriete->proprieteTraduction[0];
        }
        return View::make('compte.inscription_nonfinie')
        ->with( compact('proprietes') );
        
    }
}