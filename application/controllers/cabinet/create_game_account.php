<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Create_Game_Account extends Controllers_Cabinet_Base
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('users_on_server_model');
    }
    
    
	public function index()
	{
        if($this->_data['server_list'])
        {
            if(isset($_POST['submit']) && $this->_data['server_list'])
            {
                $this->load->library('form_validation');

                $this->form_validation->set_error_delimiters('', '');

                if(count($this->_data['server_list']) > 1)
                {
                    $this->form_validation->set_rules('server_id', lang('Выберите сервер'), 'required|trim|integer|callback__check_server_by_id');
                }

                $this->form_validation->set_rules('login',    lang('Логин'),  'required|trim|xss_clean|min_length[' . $this->config->item('login_min_length', 'lineage') . ']|max_length[' . $this->config->item('login_max_length', 'lineage') . ']|alpha_dash|callback__check_count_game_accounts|callback__check_login');
                $this->form_validation->set_rules('password', lang('Пароль'), 'required|trim|xss_clean|min_length[' . $this->config->item('password_min_length', 'lineage') . ']|max_length[' . $this->config->item('password_max_length', 'lineage') . ']');

                if($this->form_validation->run())
                {
                    $server_id = key($this->_data['server_list']);

                    if(count($this->_data['server_list']) > 1)
                    {
                        $server_id = (int) ($this->input->post('server_id') ? $this->input->post('server_id') : $server_id);
                    }

                    $config   = $this->_l2_settings['servers'][$server_id];
                    $login    = $this->input->post('login', true);
                    $password = $this->input->post('password', true);



                    $password_encode = pass_encode($password, $this->_l2_settings['logins'][$config['login_id']]['password_type']);

                    $res = $this->lineage
                        ->set_id($config['login_id'])
                        ->set_type('logins')
                        ->insert_account($login, $password_encode);

                    if(is_numeric($res))
                    {
                        $data_db = array(
                            'user_id'             => $this->auth->get('user_id'),
                            'login_id'            => $config['login_id'],
                            'server_id'           => $server_id,
                            'server_account_name' => $login,
                            'date'                => db_date(),
                        );

                        $this->users_on_server_model->add($data_db);

                        $this->_data['message'] = Message::true('Игровой аккаунт создан');
                    }
                    else
                    {
                        Message::$_translate = false;
                        $this->_data['message'] = Message::false($this->lineage->get_errors());
                        Message::$_translate = true;
                    }
                }
            }
        }
        else
        {
            $this->_data['message'] = Message::info('Сервер(а) в данный момент не доступны, попробуйте позже');
        }

        
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
    
    /**
     * Проверка кол-ва игровых аккаунтов
     * 
     * @return boolean
     */
    public function _check_count_game_accounts()
    {
        $server_id = key($this->_data['server_list']);
        
        if(count($this->_data['server_list']) > 1)
        {
            $server_id = (int) ($this->input->post('login_id') ? $this->input->post('login_id') : $server_id);
        }
        
        
        
        $config = $this->_l2_settings['servers'][$server_id];
        
        $data_db_where = array(
            'user_id'   => $this->auth->get('user_id'),
            'server_id' => $server_id,
            'login_id'  => $config['login_id'],
        );
        
        $count = $this->users_on_server_model->get_count($data_db_where);
        
        if($count >= $this->config->item('count_game_accounts_allowed'))
        {
            $this->form_validation->set_message('_check_count_game_accounts', '');
            
            $this->_data['message'] = Message::info('Вы достигли лимита на создание игровых аккаунтов');
            return false;
        }
        
        return true;
    }
    
    /**
     * Проверка аккаунта на сервере
     * 
     * @return boolean
     */
    public function _check_login()
    {
        $server_id = key($this->_data['server_list']);

        if(count($this->_data['server_list']) > 1)
        {
            $server_id = (int) ($this->input->post('server_id') ? $this->input->post('server_id') : $server_id);
        }

        $config   = $this->_l2_settings['servers'][$server_id];
        $login    = $this->input->post('login', true);
        $password = $this->input->post('password', true);
        
        
        // Проверка не занят ли аккаунт на сервере
        $res = $this->lineage
            ->set_id($config['login_id'])
            ->set_type('logins')
            ->get_account_by_login($login);
        
        if($res)
        {
            $this->form_validation->set_message('_check_login', lang('Аккаунт занят'));
            return false;
        }
        
        return true;
    }
}