<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Settings extends Controllers_Backend_Base
{
    public function __construct()
    {
        parent::__construct();
        
        $class = strtolower(__CLASS__);
        $this->_model = $class . '_model';
        $this->_view  = $class;
        
        
        $this->load->model($this->_model);
        
        $this->load->library('table');
    }
    
    // @TODO Не используется
	public function index()
	{
        $this->load->model('settings_group_model');
        
        $this->_data['content'] = $this->settings_group_model->get_list(0, 0, array('allow' => '1'));
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    public function group()
    {
        $id = (int) get_segment_uri(4);
        
        if($id < 1)
        {
            redirect('backend/' . $this->_view);
        }
        
        // Save
        if(isset($_POST['submit']))
        {
            $posts = $this->input->post();
        
            unset($posts['submit']);

            if($this->settings_model->edit_settings($posts))
            {
                $this->cache->delete('site_settings');
                $this->_data['message'] = Message::true('Настройки сохранены');
            }
            else
            {
                $this->_data['message'] = Message::false('Ошибка! Не удалось записать данные в БД');
            }
        }
        
        $this->_data['content'] = $this->settings_model->get_settings_by_group_id($id);
        
        
        $this->load->model('settings_group_model');
        
        $this->_data['group_name'] = $this->settings_group_model->get_row(array('id' => $id));
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
}