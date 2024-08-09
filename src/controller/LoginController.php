<?php

namespace App\controller;

class LoginController extends BaseController
{ 
    public function login() {
        parent::loadview("login");
    }
}