<?php

namespace App\controller;

class HomeController extends BaseController
{ 
    public function index() {
        parent::loadview("home");
    }
}