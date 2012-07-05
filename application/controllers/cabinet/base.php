<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Controllers_Cabinet_Base extends GW_Controller
{
	public function __construct()
    {
        parent::__construct();
        
        $this->load->set_view_path($this->config->item('template'));
        
        if(!$this->auth->is_logged())
        {
            redirect('login');
        }
        
        // <meta>
        $this->set_meta_title(lang('Личный кабинет'));
        $this->set_meta_description();
        $this->set_meta_keywords();
        
        // Страницы для меню
        $this->_data['page_in_menu'] = $this->pages_model->get_pages_in_menu();
        
        // Список серверов
        $this->_data['server_list'] = $this->servers_model->get_servers_name(true);
    }
    
    /**
     * Проверка сервера
     */
    public function _check_server_by_id()
    {
        if(!isset($this->_data['server_list'][$this->input->post('server_id')]))
        {
            $this->form_validation->set_message('_check_server_by_id', lang('Сервер не существует'));
            return false;
        }
        
        return true;
    }
}