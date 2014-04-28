<?php

class Admin_BaseController extends \BaseController
{
    public function index()
    {

        return View::make('admin.index');
    }
}