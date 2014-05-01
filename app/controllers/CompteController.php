<?php

Use Carbon\Carbon;

class CompteController extends BaseController {

	public function index() {

        $nbInscriptionProprietePasFinie = User::find(Auth::user()->id)->propriete()->whereNotIn('etape',array('8',"","1"))->count();

        return View::make('compte.index')
        ->with(compact('nbInscriptionProprietePasFinie'));
    }

    public function listLocation(  ){

        //todo afficher la liste des locations pas finie, voir requete au dessus
        if(Session::has('proprieteId')){
            
            Session::forget('proprieteId');
        }

        $proprietes = Propriete::getLocations();

        $imageType = imageType::whereNom(Config::get('var.image_standard'))->first();

        return View::make('compte.listLocation', array('page'=>'listLocation'))
        ->with( compact(array('proprietes','imageType')) );
        
    }

    public function listCommentaires(  ){

        dd(Auth::user()->with('commentaire')->get());

        return View::make('compte.commentaires', array('page'=>'commentaires'))
        ->with(compact('commentaires'));
    }
}