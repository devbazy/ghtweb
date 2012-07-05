<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Logout extends Controllers_Cabinet_Base
{
	public function index()
    {
        $this->auth->logout();
        
        redirect();
	}
}