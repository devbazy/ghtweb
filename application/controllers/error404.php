<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Error404 extends Controllers_Frontend_Base
{
    public function index()
    {
        $this->tpl('errors/404');
    }
}