<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Game_accounts extends Controllers_Cabinet_Base
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('users_on_server_model');
    }
    
    
    
    public function index()
    {
        $this->set_meta_title(lang('Игровые аккаунты'));

        $accounts_list = array();

        if($this->_data['server_list'])
        {
            $data_db_where = array(
                'user_id' => $this->auth->get('user_id'),
            );

            $user_accounts = $this->users_on_server_model->get_list(0, 0, $data_db_where);

            foreach($this->_data['server_list'] as $server_id => $server_name)
            {
                $logins = array();

                foreach($user_accounts as $val)
                {
                    if($val['server_id'] == $server_id)
                    {
                        $logins[] = $val['server_account_name'];
                    }
                }

                $accounts = array();

                if($logins)
                {
                    $config = $this->_l2_settings['servers'][$server_id];

                    $accounts = $this->lineage
                        ->set_id($config['login_id'])
                        ->set_type('logins')
                        ->get_accounts_by_login($logins);

                    if($accounts === false && $this->lineage->get_errors())
                    {
                        $accounts_list[$server_id]['error'] = $this->lineage->get_errors();
                    }
                }

                $accounts_list[$server_id]['name']     = $server_name;
                $accounts_list[$server_id]['accounts'] = $accounts;
            }
        }
        else
        {
            $this->_data['message'] = Message::info('Сервер(а) в данный момент не доступны');
        }
        
        $this->_data['game_accounts_list'] = $accounts_list;
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }

    /**
     * Смена пароля
     */
    public function change_password()
    {
        if(!$this->_data['server_list'])
        {
            $this->session->set_flashdata('message', Message::info('Сервер(а) в данный момент не доступны'));
            redirect('cabinet/game_accounts');
        }

        // Входящие данные
        $login     = get_segment_uri(4);
        $server_id = (int) get_segment_uri(5);

        if($server_id < 1 || mb_strlen($login) < $this->config->item('login_min_length', 'lineage'))
        {
            redirect('cabinet/game_accounts');
        }

        $this->set_meta_title(lang('Смена пароля от аккаунта') . ' ' . $login);


        // Проверка сервера
        if(!isset($this->_l2_settings['servers'][$server_id]))
        {
            redirect('cabinet/game_accounts');
        }

        // Конфиг
        $config  = $this->_l2_settings['servers'][$server_id];


        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');

            $this->form_validation->set_error_delimiters('', '');

            $this->form_validation->set_rules('old_password', 'lang:Старый пароль', 'required|trim|xss_clean|min_length[' . $this->config->item('password_min_length', 'lineage') . ']|max_length[' . $this->config->item('password_max_length', 'lineage') . ']');
            $this->form_validation->set_rules('new_password', 'lang:Новый пароль', 'required|trim|xss_clean|min_length[' . $this->config->item('password_min_length', 'lineage') . ']|max_length[' . $this->config->item('password_max_length', 'lineage') . ']');

            if($this->form_validation->run())
            {
                $account_data = $this->lineage
                    ->set_id($config['login_id'])
                    ->set_type('logins')
                    ->get_account_by_login($login);

                if(!$account_data)
                {
                    $this->_data['message'] = Message::false($this->lineage->get_errors());
                }
                else
                {
                    $old_password = $this->input->post('old_password', true);
                    $new_password = $this->input->post('new_password', true);

                    $password_encode_type = $this->_l2_settings['logins'][$config['login_id']];
                    $old_password_encode  = pass_encode($old_password, $password_encode_type['password_type']);


                    if($account_data['password'] == $old_password_encode)
                    {
                        $new_password_encode = pass_encode($new_password, $password_encode_type['password_type']);

                        $res = $this->lineage
                            ->set_id($config['login_id'])
                            ->set_type('logins')
                            ->change_password_on_account($new_password_encode, $login);

                        if($res)
                        {
                            $this->_data['message'] = Message::true('Пароль изменён');
                        }
                        else
                        {
                            log_message('error', 'Не удалось записать новый пароль от игрового аккаута в БД логин сервера, ' . __LINE__ . ', ' . __FILE__);
                            Message::$_translate = false;
                            $this->_data['message'] = Message::false($this->lineage->get_errors());
                            Message::$_translate = true;
                        }
                    }
                    else
                    {
                        $this->_data['message'] = Message::false('Введенный пароль и пароль от аккаунта не совпадают');
                    }
                }
            }
        }

        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    /**
     * Просмотр персонажей на аккаунте
     */
    public function view_account()
    {
        if(!$this->_data['server_list'])
        {
            $this->session->set_flashdata('message', Message::info('Сервер(а) в данный момент не доступны'));
            redirect('cabinet/game_accounts');
        }


        $server_id = (int) get_segment_uri(4);
        $login     = get_segment_uri(5);
        
        if(!isset($this->_data['server_list'][$server_id]) || mb_strlen($login) < $this->config->item('login_min_length', 'lineage'))
        {
            redirect('cabinet/game_accounts');
        }

        $this->set_meta_title(lang('Просмотр аккаунта') . ' ' . $login);
        
        $user_id  = $this->auth->get('user_id');
        $config   = $this->_l2_settings['servers'][$server_id];
        
        
        // Проверка, принадлежит ли аккаунт данному юзеру
        $data_db_where = array(
            'user_id'             => $user_id,
            'server_account_name' => $login,
            'server_id'           => $server_id,
            'login_id'            => $config['login_id'],
        );
        
        $check_login = $this->users_on_server_model->get_row($data_db_where);
        
        if(!$check_login)
        {
            $this->session->set_flashdata('message', Message::info('Вы можете просматривать только свои аккаунты'));
            redirect('cabinet/game_accounts');
        }

        
        // Достаю персонажей с аккаунта
        $this->_data['characters'] = $this->lineage
            ->set_id($server_id)
            ->set_type('servers')
            ->get_characters_by_login($login);
        
        // Список городов для телепорта
        $this->_data['city_teleports'] = city_for_teleport();
        
        if($this->_data['characters'] === false)
        {
            $this->_data['message'] = Message::false($this->lineage->get_errors());
        }
        
        
        // Телепорт
        if(isset($_POST['submitTP']) && $this->_data['characters'])
        {
            $server_config = $this->_l2_settings['servers'][$server_id];
            
            if($server_config['allow_teleport'])
            {
                $this->load->library('form_validation');
                
                $this->form_validation->set_error_delimiters('', '');
                
                $this->form_validation->set_rules('city_id', 'lang:Выберите город', 'required|trim|is_natural|callback__check_city');
                $this->form_validation->set_rules('char_id', '', 'required|trim|integer');

                if($this->form_validation->run())
                {
                    $char_id = (int) $this->input->post('char_id');
                    $city_id = (int) $this->input->post('city_id');
                    
                    $character_data = array();
                    
                    // Забираю данные персонажа по его char_id
                    foreach($this->_data['characters'] as $key => $row)
                    {
                        if($row['char_id'] == $char_id)
                        {
                            $character_data = $this->_data['characters'][$key];
                            break;
                        }
                    }
                    
                    if($character_data)
                    {
                        // Проверка чтобы нужному персонажу делали ТП
                        if(($character_data['account_name'] == $check_login['server_account_name']) && ($server_id == $check_login['server_id']))
                        {
                            $tp_allow = true;
                            
                            // Если чар в игре
                            if($character_data['online'] == 1)
                            {
                                $this->_data['message'] = Message::false('Персонаж в игре');
                                $tp_allow = false;
                            }
                            // @TODO
                            // Если чар в тюрьме
                            /*elseif()
                            {
                                
                            }*/
                            else
                            {
                                $this->load->model('teleports_model');

                                $data_db_where = array(
                                    'char_name' => $character_data['char_name'],
                                    'server_id' => $server_id,
                                );

                                $teleport_data = $this->teleports_model->get_row($data_db_where);

                                if($teleport_data)
                                {
                                    $date = strtotime($teleport_data['date']) + ($server_config['teleport_time'] * 60);

                                    if(time() < $date)
                                    {
                                        $this->_data['message'] = Message::info('Вы уже телепортировались в :city_name<br />Телепортироваться можно раз в :min мин.', array(
                                            ':city_name' => '<b>' . $this->_data['city_teleports'][$teleport_data['city_id']] . '</b>',
                                            ':min'       => $config['teleport_time'],
                                        ));

                                        $tp_allow = false;
                                    }
                                }
                            }
                            
                            
                            // Телепортация
                            if($tp_allow)
                            {
                                $city = coordinates_for_teleport($city_id);
                                
                                $coordinats = $city['coordinates'][array_rand($city['coordinates'])];
                                
                                $data_db = array(
                                    'x' => $coordinats['x'],
                                    'y' => $coordinats['y'],
                                    'z' => $coordinats['z'],
                                );
                                
                                $res = $this->lineage
                                    ->set_id($server_id)
                                    ->set_type('servers')
                                    ->change_coordinates($data_db, $char_id);
                                
                                if($res)
                                {
                                    // Записываю время последнего ТП
                                    if($teleport_data)
                                    {
                                        $data_db_where = array(
                                            'char_name' => $character_data['char_name'],
                                            'char_id'   => $char_id,
                                            'server_id' => $server_id,
                                            'city_id'   => $city_id,
                                        );
                                        
                                        $data_db = array(
                                            'date' => db_date(),
                                        );
                                        
                                        $this->teleports_model->edit($data_db, $data_db_where);
                                    }
                                    else
                                    {
                                        $data_db = array(
                                            'char_name' => $character_data['char_name'],
                                            'char_id'   => $char_id,
                                            'server_id' => $server_id,
                                            'city_id'   => $city_id,
                                            'date'      => db_date(),
                                        );

                                        $this->teleports_model->add($data_db);
                                    }
                                    
                                    
                                    $this->_data['message'] = Message::true('Персонаж :char был телепортирован в :city', array(
                                        ':char' => '<b>' . $character_data['char_name'] . '</b>',
                                        ':city' => '<b>' . $city['name'] . '</b>',
                                    ));
                                }
                                elseif($res === false && $this->lineage->get_errors())
                                {
                                    log_message('error', 'Не удалось записать новые координаты для телепорта персонажа в БД, ' . __LINE__ . ', ' . __FILE__);
                                    Message::$_translate = false;
                                    $this->_data['message'] = Message::false($this->lineage->get_errors());
                                    Message::$_translate = true;
                                }
                                else
                                {
                                    log_message('error', 'Не удалось записать новые координаты для телепорта персонажа в БД, ' . __LINE__ . ', ' . __FILE__);
                                    $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
                                }
                            }
                        }
                        else
                        {
                            $this->_data['message'] = Message::false('Вы можете телепортировать только своих персонажей');
                        }
                    }
                    else
                    {
                        log_message('error', 'Аккаунт для телепорта не найден в БД, ' . __LINE__ . ', ' . __FILE__);
                        $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
                    }
                }
            }
            else
            {
                $this->_data['message'] = Message::info('Телепортация на сервере отключена');
            }
        }
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    /**
     * Проверка города при телепорте
     */
    public function _check_city()
    {
        if(!isset($this->_data['city_teleports'][$this->input->post('city_id')]))
        {
            $this->form_validation->set_message('_check_city', lang('Выберите город'));
            return false;
        }
        
        return true;
    }
    
    /**
     * Проверка логина
     * 
     * @return boolean
     */
    public function _check_login()
    {
        $server_id = (int) $this->input->post('server_id');
        $login     = $this->input->post('login', true);
        
        $config    = $this->_l2_settings['servers'][$server_id];
        
        
        // Проверка, принадлежит ли аккаунт данному юзеру
        $data_db_where = array(
            'user_id'             => $this->auth->get('user_id'),
            'server_account_name' => $login,
            'server_id'           => $server_id,
            'login_id'            => $config['login_id'],
        );
        
        $account = $this->users_on_server_model->get_row($data_db_where);
        
        if(!$account)
        {
            log_message('error', 'Попытка изменить пароль от не своего игрового аккаунта. Данные: ' . print_r($data_db_where, true) . __LINE__ . ', ' . __FILE__);
            $this->form_validation->set_message('_check_login', lang('Аккаунт не найден'));
            $this->_ajax_data['mesage'] = Message::false('Аккаунт не найден');
            return false;
        }
        
        return true;
    }
}