<?php

class Admin_DatabaseController extends \Admin_BaseController
{
    public function index()
    {
        return View::make('admin.database.index');
    }
}