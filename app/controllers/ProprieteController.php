<?php

class ProprieteController extends BaseController {
    
    public function getPhoto( $proprieteId ){

       return Propriete::getPhoto( $proprieteId, null, 'json' );
   }

}