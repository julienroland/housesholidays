<?php

class HomeController extends BaseController {

	public function index() {

        return View::make('index', array('page'=>'home','widget'=>array('carte','datepicker')));
    }

}