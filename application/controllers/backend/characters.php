<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Characters extends Controllers_Backend_Base
{
    /**
     * @var array: Названия полей которые будут браться из $_GET для поиска
     */
    private $_search_fields = array('account_name', 'char_name', 'level');
    
    
    
    public function __construct()
    {
        parent::__construct();
        
        $class = strtolower(__CLASS__);
        $this->_view  = $class;

        $this->_data['server_list'] = $this->servers_model->get_servers_name();
    }
    
    
	public function index()
	{
        // Данные для страниицы
        $this->_data['content']    = array();
        $this->_data['pagination'] = '';
        $this->_data['count']      = 0;
        
        
        if($this->_data['server_list'])
        {
            $server_id = ((int) get_segment_uri(3) ? (int) get_segment_uri(3) : key($this->_data['server_list']));

            $data_db_like = array();
            
            // Поиск
            if($this->input->get())
            {
                $get = $this->input->get();

                foreach($get as $key => $val)
                {
                    $val = trim($val);

                    if(in_array($key, $this->_search_fields) && $val != '')
                    {
                        $data_db_like[$key] = $val;
                    }
                }
            }

            $this->lineage
                ->set_id($server_id)
                ->set_type('servers');

            $count    = $this->lineage->get_count_characters(NULL, $data_db_like);
            $page     = (int) $this->config->item('characters_per_page', 'backend');
            $per_page = (int) $this->input->get('per_page');
            
            // Пагинация
            $this->load->library('pagination');
            
            $this->pagination->initialize(array(
                'total_rows' => $count,
                'per_page'   => $per_page,
            )); 
            
            $this->_data['pagination'] = $this->pagination->create_links();
            $this->_data['content']    = $this->lineage->get_characters($page, $per_page, NULL, 'level', 'desc', $data_db_like);
            $this->_data['server_id']  = $server_id;
            $this->_data['count']      = $count;
        }
        else
        {
            $this->_data['message'] = Message::info('Серверов нет');
        }
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }

    /**
     * Просмотр персонажей на аккаунте
     */
    public function characters_in_account()
    {
        $this->_data['content'] = array();

        if($this->_data['server_list'])
        {
            $server_id    = (int) get_segment_uri(3);
            $account_name = get_segment_uri(5);

            if($server_id < 1 || mb_strlen($account_name) < $this->config->item('login_min_length', 'lineage'))
            {
                redirect_back();
            }

            $this->lineage
                ->set_id($server_id)
                ->set_type('servers');

            $this->_data['content']   = $this->lineage->get_characters_by_login($account_name);
            $this->_data['server_id'] = $server_id;
            $this->_data['count']     = count($this->_data['content']);
        }
        else
        {
            $this->_data['message'] = Message::info('Серверов нет');
        }

        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }

    /**
     * Просмотр предметов игрока
     */
    public function items()
    {
        $this->data['content'] = array();

        if($this->_data['server_list'])
        {
            $server_id = (int) get_segment_uri(3);
            $char_id   = (int) get_segment_uri(5);

            if($server_id < 1 || $char_id < 1)
            {
                redirect('backend/characters/' . $server_id);
            }

            $this->lineage
                ->set_id($server_id)
                ->set_type('servers');

            $count    = $this->lineage->get_count_character_items($char_id);
            $page     = (int) $this->config->item('users_items_per_page', 'backend');
            $per_page = (int) $this->input->get('per_page');

            // Пагинация
            $this->load->library('pagination');

            $this->pagination->initialize(array(
                'total_rows' => $count,
                'per_page'   => $per_page,
            ));

            $this->_data['pagination'] = $this->pagination->create_links();
            $this->_data['content']    = $this->lineage->get_character_items($page, $per_page, array('owner_id' => $char_id), 'count', 'desc');
            $this->_data['char_data']  = $this->lineage->get_character_by_char_id($char_id);

            if($this->_data['content'])
            {
                $items_id = array();

                // Названия предметов
                foreach($this->_data['content'] as $item)
                {
                    $items_id[] = $item['item_id'];
                }

                $this->load->model('all_items_model');
                $items_name_res = $this->all_items_model->get_list_where_in_by_id($items_id);
                $items_name     = array();

                foreach($items_name_res as $row)
                {
                    $items_name[$row['item_id']] = $row['name'];
                }

                foreach($this->_data['content'] as $key => $item)
                {
                    if(isset($items_name[$item['item_id']]))
                    {
                        $this->_data['content'][$key]['item_name'] = $items_name[$item['item_id']];
                    }
                }

                unset($items_name_res, $items_name);
            }

            $this->_data['server_id'] = $server_id;

            $this->_data['count'] = $count;
        }
        else
        {
            $this->_data['message'] = Message::info('Серверов нет');
        }

        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }

    /**
     * Добавление предмета
     */
    public function add_item()
    {
        if(isset($_POST))
        {
            $this->load->library('form_validation');

            $this->form_validation->set_error_delimiters('', '<br />');

            $this->form_validation->set_rules('item_id', 'Название', 'required|trim');
            $this->form_validation->set_rules('char_id', 'Char_id не найден', 'required|is_natural_no_zero');
            $this->form_validation->set_rules('server_id', 'Server_id не найден', 'required|is_natural_no_zero');
            $this->form_validation->set_rules('count', 'Кол-во', 'is_natural_no_zero');
            $this->form_validation->set_rules('enchant', 'Заточка', 'is_natural');
            $this->form_validation->set_rules('type', 'Тип', 'trim');

            if($this->form_validation->run())
            {
                $server_id = (int) $this->input->post('server_id');

                if(!isset($this->_data['server_list'][$server_id]))
                {
                    $this->session->set_flashdata('message', Message::false('Сервер не найден'));
                    redirect_back();
                }

                $data_db = array(
                    'owner_id'      => (int) $this->input->post('char_id'),
                    'item_id'       => (int) $this->input->post('item_id'),
                    'count'         => (int) $this->input->post('count'),
                    'enchant_level' => (int) $this->input->post('enchant'),
                    'loc'           => 'INVENTORY',
                );

                $type = ($this->input->post('type') == 'insert' ? 'insert' : 'update');

                $this->lineage
                    ->set_id($server_id)
                    ->set_type('servers');

                if($type == 'insert')
                {
                    $res = $this->lineage->insert_item($data_db['item_id'], $data_db['count'], $data_db['owner_id'], $data_db['enchant_level'], $data_db['loc']);

                    if($res)
                    {
                        $this->session->set_flashdata('message', Message::true('Предмет добавлен'));
                    }
                    else
                    {
                        $this->session->set_flashdata('message', Message::false('Ошибка! Не удалось записать данные в БД'));
                    }
                }
                else
                {
                    $msg_status = false;

                    // Если есть предмет делаю UPDATE если нет делаю INSERT
                    if(($item_data = $this->lineage->get_character_item_by_item_id($data_db['owner_id'], $data_db['item_id'])))
                    {
                        // Найден
                        $res = $this->lineage->edit_item($item_data['object_id'], $item_data['count'] + $data_db['count'], $data_db['owner_id'], $data_db['enchant_level'], $data_db['loc']);

                        if($res)
                        {
                            $msg_status = true;

                        }
                    }
                    else
                    {
                        // Не найден
                        $res = $this->lineage->insert_item($data_db['item_id'], $data_db['count'], $data_db['owner_id'], $data_db['enchant_level'], $data_db['loc']);

                        if($res)
                        {
                            $msg_status = true;
                        }
                    }

                    if($msg_status)
                    {
                        $this->session->set_flashdata('message', Message::true('Предмет добавлен'));
                    }
                    else
                    {
                        $this->session->set_flashdata('message', Message::false('Ошибка! Не удалось записать данные в БД'));
                    }
                }
            }

            if(validation_errors())
            {
                $this->session->set_flashdata('message', Message::false(validation_errors()));
            }
        }

        redirect_back();
    }

    /**
     * Удаление всех предметов
     */
    public function del_items()
    {
        if(isset($_POST))
        {
            $server_id = (int) $this->input->post('server_id');
            $char_id   = (int) $this->input->post('char_id');

            if($server_id < 1 || $char_id < 1)
            {
                $this->session->set_flashdata('message', Message::false('Ошибка! Не были переданы необходимые данные'));
                redirect_back();
            }

            $this->lineage
                ->set_id($server_id)
                ->set_type('servers');

            // Проверяю чтобы был offline
            if($this->lineage->get_online_status($char_id))
            {
                $this->session->set_flashdata('message', Message::info('Персонаж в игре'));
                redirect_back();
            }


            if($this->lineage->del_items_by_owner_id($char_id))
            {
                $this->session->set_flashdata('message', Message::true('Предметы удалены'));
            }
            else
            {
                $this->session->set_flashdata('message', Message::false('Ошибка! Не удалось удалить данные в БД'));
            }
        }

        redirect_back();
    }

    /**
     * Удаление предмета
     */
    public function del_item()
    {
        $server_id = (int) get_segment_uri(3);
        $item_id   = (int) get_segment_uri(5);
        $char_id   = (int) get_segment_uri(7);

        if(!isset($this->_data['server_list'][$server_id]) || $item_id < 1 || $char_id < 1)
        {
            redirect_back();
        }


        $this->lineage
            ->set_id($server_id)
            ->set_type('servers');


        // Проверяю чтобы был offline
        if($this->lineage->get_online_status($char_id))
        {
            $this->session->set_flashdata('message', Message::info('Персонаж в игре'));
            redirect_back();
        }

        if($this->lineage->del_item($item_id))
        {
            $this->session->set_flashdata('message', Message::true('Предмет удалён'));
        }
        else
        {
            $this->session->set_flashdata('message', Message::false('Ошибка! Не удалось удалить данные в БД'));
        }

        redirect_back();
    }
}