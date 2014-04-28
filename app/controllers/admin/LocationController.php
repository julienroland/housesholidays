<?php

class Admin_LocationController extends \Admin_BaseController
{
    public function index()
    {
        return View::make('admin.locations.index');
    }
}