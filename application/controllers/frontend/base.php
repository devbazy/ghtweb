<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Controllers_Frontend_Base extends GW_Controller
{
	public function __construct()
    {
        parent::__construct();
        
        $this->load->set_view_path($this->config->item('template'));
        
        // <meta>
        $this->set_meta_title(lang('Главная'));
        $this->set_meta_description();
        $this->set_meta_keywords();
        
        // Страницы для меню
        $this->_data['page_in_menu'] = $this->pages_model->get_pages_in_menu();
    }
}