<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class GW_Controller extends CI_Controller
{
    /**
     * @var array: Глобальный массив, виден во всех шаблонах
     */
    public $_data = array(
        'message' => '', // Сообщения
    );
    
    /**
     * @var array: Глобальный массив для AJAX запросов
     */
    public $_ajax_data = array(
        'status'     => false,
        'message'    => '',
        'redirect'   => '',
    );
    
    /**
     * @var array: Группы пользователей
     */
    public $_user_groups = array();
    
    /**
     * @var array: Настройки для серверов/логинов
     */
    public $_l2_settings = array();
    
    


    public function __construct()
    {
        parent::__construct();
        
        // Драйвер кэширования
        $this->load->driver('cache', array('adapter' => 'file'));
        
        // Достаю настройки
        $settings = $this->settings_model->get_settings_list();
        $this->config->set_item($settings);
        unset($settings);
        
        // Группы пользователей
        $this->_user_groups = $this->user_groups_model->get_groups_list();
        
        // Настройки для серверов
        $this->_l2_settings['servers'] = $this->servers_model->get_servers_list();
        
        // Настройки для логинов
        $this->_l2_settings['logins'] = $this->logins_model->get_logins_list();
        
        // Конфиг Lineage
        $this->config->load('lineage', true);
        
        // Драйвер для Lineage
        $this->load->driver('Lineage');

        // Profiler
        if(ENVIRONMENT == 'development' && !$this->input->is_ajax_request())
        {
            //$this->output->enable_profiler(TRUE);
        }
    }
    
    /**
     * Добавление титула <meta>
     * 
     * @param string   Текст
     * @param string   Куда вставить текст, до или после текущего титула
     */
    protected function set_meta_title($string = '', $where = '')
    {
        $title     = $this->config->item('meta_title');
        $separator = $this->config->item('meta_title_separator');
        
        $this->_data['meta_title'] = $title;
        $this->_data['page_title'] = $string;
        
        if($string != '')
        {
            switch($where)
            {
                case 'before':
                    $this->_data['meta_title'] = $string . $separator . $this->config->item('meta_title');
                    break;
                case 'after':
                    $this->_data['meta_title'] = $title . $separator . $string;
                    break;
                default:
                    $this->_data['meta_title'] = $string;
            }
        }
    }
    
    /**
     * Добавление описание <meta>
     * 
     * @param string   Текст
     */
    protected function set_meta_description($string = '')
    {
        $this->_data['meta_description'] = $string;
    }
    
    /**
     * Добавление ключевых слов <meta>
     */
    protected function set_meta_keywords($string = '')
    {
        $this->_data['meta_keywords'] = $string;
    }
    
    /**
     * Шаблоны сайта
     * 
     * @param string: Название шаблона
     */
    public function tpl($tpl_name = 'main')
    {
        $pre = '';
        
        if(get_segment_uri(1) == 'cabinet')
        {
            $pre = 'cabinet/';
        }
        
        $this->load->view('layouts/header', $this->_data);
        $this->load->view($pre . strtolower($tpl_name));
        $this->load->view('layouts/footer');
    }
    
    
    
    /** CALLBACK **/
    
        
    /**
     * Проверка логина (users)
     * 
     * Используется при регистрации и в админке, создание пользователя
     * 
     * @return boolean
     */
    public function _check_user_login()
    {
        $data_db_where = array(
            'login' => $this->input->post('login', true),
        );
        
        if($this->users_model->get_row($data_db_where))
        {
            $this->form_validation->set_message('_check_user_login', lang('Логин уже занят'));
            return false;
        }
        
        return true;
    }
    
    /**
     * Проверка Email
     * 
     * Используется при регистрации и в админке, создание пользователя
     * 
     * @return boolean
     */
    public function _check_user_email()
    {
        // Если в конфиге отключена проверка по EMAIL
        if(!$this->config->item('one_account_per_email'))
        {
            return true;
        }
        
        $data_db_where = array(
            'email' => $this->input->post('email', true),
        );
        
        if($this->users_model->get_row($data_db_where))
        {
            $this->form_validation->set_message('_check_user_email', lang('На этот Email уже зарегистрирован аккаунт'));
            return false;
        }
    }
    
    /**
     * Проверка группы пользователя
     * 
     * @return boolean 
     */
    public function _check_user_group()
    {
        $groups = $this->user_groups_model->get_groups_names();
        
        if(!isset($groups[$this->input->post('group')]))
        {
            $this->form_validation->set_message('_check_user_group', lang('Группа пользователя не правильная'));
            return false;
        }
        
        return true;
    }
    
    /**
     * Проверка капчи
     * 
     * @return boolean
     */
    public function _check_captcha()
    {
        if(!$this->captcha->check_captcha($this->input->post('captcha'), $this->input->post('captcha_id')))
        {
            $this->form_validation->set_message('_check_captcha', lang('Код с картинки введен не верно'));
            return false;
        }
        
        return true;
    }
}