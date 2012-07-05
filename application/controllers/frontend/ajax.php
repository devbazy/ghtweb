<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ajax extends GW_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        if(!$this->input->is_ajax_request())
        {
            die;
        }
    }


    public function captcha_reload()
	{
        $captcha = $this->captcha->get_img();
        
		die(json_encode($captcha));
	}
}