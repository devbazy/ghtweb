<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Базовый класс админки
class Controllers_Backend_Base extends GW_Controller
{
    protected $_view  = '';
    protected $_model = '';




    public function __construct()
    {
        parent::__construct();
        
        if($this->auth->is_logged() == false)
        {
            redirect();
        }
        
        if(!$this->_user_groups[$this->auth->get('group')]['allow_cp'])
        {
            redirect();
        }
        
        
        Message::$_translate = false;
        
        
        $backend_template = 'backend';
        
        $this->load->set_view_path($backend_template);
        
        define('TPL_DIR', $backend_template);
        
        $this->load->helper('array');
        
        $this->set_meta_title('Админцентр');
        
        $this->load->config('backend', true);
        
        $this->get_settings_group();
    }
    
    /**
     * Проверка введенного языка
     *
     * @return boolean
     */
    public function _check_language()
    {
        if(!$this->config->item($this->input->post('lang'), 'languages'))
        {
            $this->form_validation->set_message('_check_language', 'Такого языка нет');
            return false;
        }
        
        return true;
    }

    /**
     * Возвращает список групп пользователей
     *
     * @return array(group_id => group_name)
     */
    public function get_user_group_name()
    {
        $result = array();

        foreach($this->_user_groups as $group)
        {
            $result[$group['id']] = $group['group_name'];
        }

        return $result;
    }

    /**
     * Группы для настроек
     */
    public function get_settings_group()
    {
        $this->load->model('settings_group_model');
        
        $data_db_where = array(
            'allow' => '1',
        );
        
        $row = $this->settings_group_model->get_list(0, 0, $data_db_where);
        
        $settings_group = array();
        
        foreach($row as $val)
        {
            $settings_group[$val['id']] = $val['title'];
        }
        
        unset($row);
        
        $this->_data['settings_group'] = $settings_group;
    }
    
    /**
     * Проверка существует ли выбранная юзером версия сервера
     * 
     * @return boolean
     */
    public function _check_version()
    {
        if(array_search($this->input->post('version'), $this->config->item('types_of_servers', 'lineage')) === false)
        {
            $this->form_validation->set_message('_check_version', 'Выбранная версия не существует');
            return false;
        }
        
        return true;
    }
}