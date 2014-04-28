<?php

class Admin_TraductionController extends \Admin_BaseController
{
    public function index()
    {
        return View::make('admin.traduction.index');
    }
}