<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Warehouse extends Controllers_Cabinet_Base
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('users_warehouse_model');
        $this->load->model('users_gifts_model');
    }
    
	public function index()
	{
        $per_page = (int) $this->config->item('warehouse_per_page');
        $page     = (int) get_segment_uri(3);
        
        $user_id = $this->auth->get('user_id');

        $data_db_where = array(
            'user_id'       => $user_id,
            'moved_to_game' => '0',
        );


        $count = $this->users_warehouse_model->get_count($data_db_where);
        
        $this->load->library('pagination');
        
        $this->pagination->initialize(array(
            'base_url'          => '/' . $this->language->get_lang() . 'cabinet/warehouse',
            'total_rows'        => $count,
            'per_page'          => $per_page,
            'page_query_string' => false,
            'uri_segment'       => uri_segment(3),
        ));
        
        
        $this->_data['pagination'] = $this->pagination->create_links();
        $this->_data['content']    = $this->users_warehouse_model->get_list($page, $per_page, $data_db_where, 'shop_products.created', 'DESC');
        $this->_data['count']      = $count;
        
        // Подарки
        //$this->_data['gifts'] = $this->users_gifts_model->get_list();
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
    
    /**
     * В игру, на склад
     */
    public function in_game()
    {
        $item_id = (int) get_segment_uri(4);
        
        if($item_id < 1)
        {
            redirect('cabinet/warehouse');
        }
        
        $user_id = $this->auth->get('user_id');
        
        // Принадлежит ли предмет юзеру
        $data_db_where = array(
            'user_id'            => $user_id,
            'users_warehouse.id' => $item_id,
            'moved_to_game'      => '0',
        );

        $item_info = $this->users_warehouse_model->get_row($data_db_where);

        if(!$item_info)
        {
            redirect('cabinet/warehouse');
        }

        $this->_data['item_info'] = $item_info;

        $user_id = $this->auth->get('user_id');

        $this->load->model('users_on_server_model');


        // Список персонажей
        $accounts_list = array();

        if($this->_data['server_list'])
        {
            $data_db_where = array(
                'user_id' => $user_id,
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
                    $accounts = $this->lineage
                        ->set_id($server_id)
                        ->set_type('servers')
                        ->get_characters_by_login($logins);

                    if($accounts === false && $this->lineage->get_errors())
                    {
                        $accounts_list[$server_id]['error'] = $this->lineage->get_errors();
                    }
                    else
                    {
                        $new_accounts = array();

                        foreach($accounts as $account)
                        {
                            $new_accounts[$account['account_name']][] = $account;
                        }

                        $accounts = $new_accounts;

                        unset($new_accounts);
                    }
                }

                $accounts_list[$server_id]['name']     = $server_name;
                $accounts_list[$server_id]['accounts'] = $accounts;
            }
        }

        $this->_data['game_accounts_list'] = $accounts_list;


        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }

    /**
     * Отправка предмета в игру
     */
    public function in_game_submit()
    {
        if(!isset($_POST))
        {
            redirect_back();
        }

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');


        $this->form_validation->set_rules('item_id', 'lang:Выберите предмет', 'required|trim|is_natural_no_zero');

        $this->form_validation->set_message('required', lang('Выберите персонажа'));
        $this->form_validation->set_rules('char_id', 'lang:Персонаж', 'required|trim|regex_match[#^[0-9|]+$#siu]');
        $this->form_validation->set_rules('item_id', null, 'required|trim|is_natural_no_zero');

        if($this->form_validation->run())
        {
            list($server_id, $char_id) = explode('|', $this->input->post('char_id'));

            // Проверка сервера
            if(isset($this->_data['server_list'][$server_id]))
            {
                // Проверка предмета
                $data_db_where = array(
                    'user_id'            => $this->auth->get('user_id'),
                    'users_warehouse.id' => (int) $this->input->post('item_id'),
                    'moved_to_game'      => '0',
                );

                $item_info = $this->users_warehouse_model->get_row($data_db_where);

                if($item_info)
                {
                    $this->lineage->set_id($server_id)->set_type('servers');


                    // Проверка online
                    $res = $this->lineage->get_online_status($char_id);

                    if($res > 0)
                    {
                        $this->session->set_flashdata('message', Message::false('Персонаж в игре'));
                    }
                    else
                    {
                        if($item_info['item_type'] == 'stock')
                        {
                            $l2_item_info = $this->lineage->get_character_item_by_item_id($char_id, $item_info['item_id']);

                            if($l2_item_info)
                            {
                                // Предмет найден, делаю UPDATE
                                $res = $this->lineage->edit_item($l2_item_info['object_id'], $l2_item_info['count'] + $item_info['count'], $char_id, $item_info['enchant_level']);
                            }
                            else
                            {
                                prt($item_info);
                                prt($l2_item_info);die;

                                // Предмет не найден, делаю INSERT
                                $res = $this->lineage->insert_item($item_info['item_id'], $item_info['count'], $char_id, $item_info['enchant_level']);
                            }
                        }
                        else
                        {
                            $res = $this->lineage->insert_item($item_info['item_id'], $item_info['count'], $char_id, $item_info['enchant_level']);
                        }

                        if($res)
                        {
                            // Меняю статус предмета на отправлен
                            $data_db = array(
                                'moved_to_game'      => '1',
                                'moved_to_game_date' => db_date(),
                            );

                            $this->users_warehouse_model->edit($data_db, $data_db_where);

                            $this->session->set_flashdata('message', Message::true('Предмет отправлен в игру'));

                            redirect('cabinet/warehouse');
                        }
                        else
                        {
                            $this->session->set_flashdata('message', Message::false('Ошибка! Обратитесь к Администрации сайта'));
                        }
                    }
                }
                else
                {
                    $this->session->set_flashdata('message', Message::false('Предмет не найден'));
                }
            }
            else
            {
                $this->session->set_flashdata('message', Message::false('Попробуйте ещё раз'));
            }
        }


        if(validation_errors())
        {
            Message::$_translate = false;
            $this->session->set_flashdata('message', Message::false(validation_errors()));
            Message::$_translate = true;
        }

        redirect_back();
    }

    public function _check_type_location()
    {
        if(!isset($this->_data['location'][$this->input->post('location')]))
        {
            $this->form_validation->set_message('_check_type_location', lang('Место локации предмета не выбрано'));
            return false;
        }

        return true;
    }
    
    /**
     * Принять/Отклонить подарок
     */
    public function gift_action()
    {
        $item_id = (int) get_segment_uri(4);
        
        if($item_id < 1)
        {
            redirect('cabinet/warehouse');
        }
        
        $action = get_segment_uri(5);
        
        if($action != 'del' && $action != 'accept')
        {
            redirect('cabinet/warehouse');
        }
        
        $user_id = $this->auth->get('user_id');
        
        // Принадлежит ли подарок нам
        $data_db_where = array(
            'to'     => $user_id,
            'id'     => $item_id,
            'status' => '0'
        );
        
        $gift_info = $this->users_gifts_model->get_row($data_db_where);
        
        if($gift_info)
        {
            if($action == 'del')
            {
                $data_db = array(
                    'status'      => '2',
                    'date_status' => db_date(),
                );
                
                $this->users_gifts_model->edit($data_db, $data_db_where);
                
                $this->session->set_flashdata('message', Message::info('Подарок удален'));
            }
            elseif($action == 'accept')
            {
                $data_db = array(
                    'status'      => '1',
                    'date_status' => db_date(),
                );

                // Меняю статус на принят
                $this->users_gifts_model->edit($data_db, $data_db_where);
                
                
                $data_db = array(
                    'user_id' => $user_id,
                    'item_id' => $gift_info['item_id'],
                    'count'   => $gift_info['count'],
                    'price'   => $gift_info['price'],
                    'date'    => db_date(),
                );
                
                $this->users_warehouse_model->add($data_db);
                
                $this->session->set_flashdata('message', Message::true('Подарок принят и помещён на склад'));
            }
        }
        else
        {
            $this->session->set_flashdata('message', Message::false('Подарок не найден'));
        }

        redirect('cabinet/warehouse');
    }

    /**
     * Подарить другу, AJAX
     */
    public function gift_friend()
    {
        if(!$this->input->is_ajax_request())
        {
            die;
        }
        
        $item_id = (int) $this->input->post('item_id');
        $login   = $this->input->post('login');
        
        if($item_id < 1 || mb_strlen($login) < 4)
        {
            $this->_ajax_data['message'] = Message::false('Необходимо ввести логин');
            die(json_encode($this->_ajax_data));
        }
        
        // Что бы не отсылали сами себе =)
        if($login == $this->auth->get('login'))
        {
            $this->_ajax_data['message'] = Message::info('Нельзя дарить самому себе');
            die(json_encode($this->_ajax_data));
        }
        
        // Ищю друга
        $data_db_where = array(
            'login' => $login,
        );
        
        $friend_info = $this->users_model->get_row($data_db_where);
        
        if(!$friend_info)
        {
            $this->_ajax_data['message'] = Message::false('Пользователь не найден');
            die(json_encode($this->_ajax_data));
        }
        
        // Проверка принадлежит ли товар пользователю
        $data_db_where = array(
            'user_id' => $this->auth->get('user_id'),
            'id'      => $item_id,
        );
        
        $item_info = $this->users_warehouse_model->get_row($data_db_where);
        
        if(!$item_info)
        {
            $this->_ajax_data['message'] = Message::false('Товар на складе не найден');
            die(json_encode($this->_ajax_data));
        }
        
        $this->db->trans_start();
        
            // Забираю товар
            $this->users_warehouse_model->del($data_db_where);
            
            $data_db = array(
                'from'    => $this->auth->get('user_id'),
                'to'      => $friend_info['user_id'],
                'item_id' => $item_info['item_id'],
                'count'   => $item_info['count'],
                'price'   => $item_info['price'],
                'date'    => db_date(),
            );
            
            $this->users_gifts_model->add($data_db);
        
        $this->db->trans_complete();
        
        if($this->db->trans_status() !== FALSE)
        {
            $this->_ajax_data['status'] = true;
            $this->_ajax_data['message'] = Message::true('Ваш подарок отправлен');
        }
        else
        {
            $this->_ajax_data['message'] = Message::false('Ошибка! Обратитесь к Администратору');
        }
        
        die(json_encode($this->_ajax_data));
    }
}