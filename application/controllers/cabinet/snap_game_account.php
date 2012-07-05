<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Snap_game_account extends Controllers_Cabinet_Base
{
    public function __construct()
    {
        parent::__construct();
        
        if(!$this->config->item('snap_game_account_allow'))
        {
            redirect('cabinet');
        }
    }
    
    
    
    public function index()
    {
        if($this->_data['server_list'])
        {
            if(isset($_POST['submit']))
            {
                $this->load->model('users_on_server_model');
                $this->load->library('form_validation');

                $this->form_validation->set_error_delimiters('', '');

                if(count($this->_data['server_list']) > 1)
                {
                    $this->form_validation->set_rules('server_id', 'lang:Выберите сервер', 'required|trim|integer|callback__check_server_by_id');
                }

                $this->form_validation->set_rules('login',    'lang:Логин',  'required|trim|xss_clean|min_length[' . $this->config->item('login_min_length', 'lineage') . ']|max_length[' . $this->config->item('login_max_length', 'lineage') . ']|alpha_dash');
                $this->form_validation->set_rules('password', 'lang:Пароль', 'required|trim|xss_clean|min_length[' . $this->config->item('password_min_length', 'lineage') . ']|max_length[' . $this->config->item('password_max_length', 'lineage') . ']');

                if($this->form_validation->run())
                {
                    $server_id = key($this->_data['server_list']);

                    if(count($this->_data['server_list']) > 1)
                    {
                        $server_id = (int) $this->input->post('server_id');
                    }

                    $config   = $this->_l2_settings['servers'][$server_id];
                    $login    = $this->input->post('login', true);
                    $password = $this->input->post('password', true);
                    $user_id  = $this->auth->get('user_id');

                    // Проверяю чтобы аккаунт не был привязан
                    $data_db_where = array(
                        'server_account_name' => $login,
                        'login_id'            => $config['login_id'],
                        'server_id'           => $server_id,
                    );

                    if(!$this->users_on_server_model->get_row($data_db_where))
                    {
                        $account_data = $this->lineage
                            ->set_id($config['login_id'])
                            ->set_type('logins')
                            ->get_account_by_login($login);

                        if($account_data)
                        {
                            $config_logins   = $this->_l2_settings['logins'][$config['login_id']];
                            $password_encode = pass_encode($password, $config_logins['password_type']);

                            if($account_data['password'] == $password_encode)
                            {
                                $data_db = array(
                                    'user_id'             => $user_id,
                                    'server_account_name' => $login,
                                    'server_id'           => $server_id,
                                    'login_id'            => $config['login_id'],
                                    'date'                => db_date(),
                                );

                                if($this->users_on_server_model->add($data_db))
                                {
                                    $this->_data['message'] = Message::true('Аккаунт успешно привязан к Вашему Мастер аккаунту');
                                }
                                else
                                {
                                    log_message('error', 'Не удалось сделать запись в БД, при прикреплении игрового аккаунта, ' . __FILE__ . ', ' . __LINE__);
                                    $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
                                }
                            }
                            else
                            {
                                $this->_data['message'] = Message::false('Пароли не совпадают');
                            }
                        }
                        elseif($account_data === false)
                        {
                            $this->_data['message'] = Message::false($this->lineage->get_errors());
                        }
                        else
                        {
                            $this->_data['message'] = Message::false('Аккаунт не найден');
                        }
                    }
                    else
                    {
                        $this->_data['message'] = Message::false('Аккаунт уже привязан к Мастер Аккаунту');
                    }
                }
            }
        }
        else
        {
            $this->_data['message'] = Message::info('Сервер(а) в данный момент не доступны');
        }
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
}