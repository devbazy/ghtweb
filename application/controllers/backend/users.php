<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users extends Controllers_Backend_Base
{
    /**
     * @var array: Названия полей которые будут браться из $_GET для поиска
     */
    private $_search_fields = array('login', 'email', 'last_ip');
    
    
    
    public function __construct()
    {
        parent::__construct();
        
        $class = strtolower(__CLASS__);
        $this->_model = $class . '_model';
        $this->_view  = $class;
        
        
        $this->load->model($this->_model);
        
        // Fields
        $this->_data['field_data'] = $this->{$this->_model}->get_fields();
    }
    
    public function index()
    {
        $per_page = (int) $this->config->item('users_per_page', 'backend');
        $page     = (int) $this->input->get('per_page');
        
        
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
        
        $count = $this->{$this->_model}->get_count(NULL, $data_db_like);
        
        // Пагинация
        $this->load->library('pagination');

        $this->pagination->initialize(array(
            'total_rows' => $count,
            'per_page'   => $per_page,
        )); 
        
        $this->_data['pagination'] = $this->pagination->create_links();
        
        
        $this->_data['content']  = $this->{$this->_model}->get_list($page, $per_page, NULL, 'joined', 'DESC', $data_db_like);
        $this->_data['count']    = $count;
        $this->_data['per_page'] = $per_page;
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    /**
     * Просмотр склада пользователя
     */
    public function warehouse()
    {
        $user_id = (int) get_segment_uri(4);
        
        if($user_id < 1)
        {
            redirect('backend/users');
        }
        
        $this->load->model('users_warehouse_model');
        
        $per_page = (int) $this->config->item('users_warehouse_per_page', 'backend');
        $page     = (int) $this->input->get('per_page');

        $data_db_where = array(
            'user_id' => $user_id,
        );
        
        $count = $this->users_warehouse_model->get_count($data_db_where);
        
        $this->load->library('pagination');

        $this->pagination->initialize(array(
            'total_rows' => $count,
            'per_page'   => $per_page,
        )); 
        
        $this->_data['pagination'] = $this->pagination->create_links();
        $this->_data['content']    = $this->users_warehouse_model->get_list($page, $per_page, array('user_id' => $user_id), 'date_payment', 'DESC');
        $this->_data['count']      = $count;
        
        $this->_data['user_data'] = $this->users_model->get_row(array('user_id' => $user_id));
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    /**
     * Добавление предмета на склад пользователю
     */
    public function add_warehouse_item()
    {
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '<br />');
            
            $this->form_validation->set_rules('user_id', '', 'required|is_natural_no_zero');
            $this->form_validation->set_rules('item_id', 'Название предмета', 'required|is_natural_no_zero');
            $this->form_validation->set_rules('count', 'Кол-во', 'required|is_natural_no_zero');
            $this->form_validation->set_rules('enchant_level', 'Заточка', 'required|is_natural');
            $this->form_validation->set_rules('item_type', 'Тип предмета', 'required|callback__check_item_type');

            if($this->form_validation->run())
            {
                $item_id       = (int) $this->input->post('item_id');
                $count         = (int) $this->input->post('count');
                $user_id       = (int) $this->input->post('user_id');
                $enchant_level = (int) $this->input->post('enchant_level');
                $item_type     = (int) $this->input->post('item_type');

                // Добавляю предмет
                $data_db = array(
                    'item_id'       => $item_id,
                    'price'         => '0',
                    'count'         => $count,
                    'category_id'   => '0',
                    'created'       => db_date(),
                    'allow'         => '0',
                    'enchant_level' => $enchant_level,
                    'item_type'     => $item_type,
                    'deleted'       => '1',
                );

                $this->load->model('shop_products_model');

                $product_id = $this->shop_products_model->add($data_db);

                // Добавляю предмет пользователю
                $data_db = array(
                    'user_id'      => $user_id,
                    'product_id'   => $product_id,
                    'date_payment' => db_date(),
                );

                $this->load->model('users_warehouse_model');

                $this->users_warehouse_model->add($data_db);

                $this->session->set_flashdata('message', Message::true('Предмет <b>' . $this->input->post('item_name') . '</b> добавлен'));
            }
            
            if(validation_errors())
            {
                $this->session->set_flashdata('message', Message::false(validation_errors()));
            }
        }
        
        redirect_back();
    }
    
    /**
     * Удаление щмотки со склада
     */
    public function del_warehouse_item()
    {
        $user_id = (int) get_segment_uri(4);
        $item_id = (int) get_segment_uri(5);
        
        if($user_id < 1 || $item_id < 1)
        {
            redirect('backend/users');
        }
        
        $this->load->model('users_warehouse_model');
        
        $data_db_where = array(
            'user_id' => $user_id,
            'id'      => $item_id,
        );
        
        if($this->users_warehouse_model->del($data_db_where, 1))
        {
            $this->session->set_flashdata('message', Message::true('Предмет удален'));
        }
        else
        {
            $this->session->set_flashdata('message', Message::true('Ошибка! Не удалось записать данные в БД'));
        }
        
        redirect('backend/users/warehouse/' . $user_id . '/');
    }
    
    // @TODO, удаление
    public function del() {}
    
    public function edit()
    {
        $user_id = (int) get_segment_uri(4);
        
        if($user_id < 1)
        {
            redirect('backend/' . $this->_view);
        }
        
        // Save
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');

            $this->form_validation->set_error_delimiters('', '');
            
            $this->form_validation->set_rules('password', 'Пароль', 'trim|min_length[4]|max_length[20]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__check_email');
            $this->form_validation->set_rules('money', 'Денег', 'trim|required|integer');
            $this->form_validation->set_rules('protected_ip', 'Защита аккаунта по IP', 'trim|valid_ip');
            $this->form_validation->set_rules('group', 'Группа', 'trim|required|integer|callback__check_group');


            if($this->form_validation->run())
            {
                $data_db = elements($this->_data['field_data'], $this->input->post(), NULL);
                
                if($this->input->post('password'))
                {
                    $data_db['password'] = $this->auth->password_encript($this->input->post('password', true));
                }
                else
                {
                    $data_db['password'] = $this->input->post('old_password', true);
                }
                
                // Сбрасываю хэш, чтобы юзера выкинуло
                $data_db['cookie_hash'] = NULL;
                
                $data_db_where = array(
                    'user_id' => $user_id,
                );
                
                if($this->{$this->_model}->edit($data_db, $data_db_where))
                {
                    $this->_data['message'] = Message::true('Данные сохранены');
                }
                else
                {
                    $this->_data['message'] = Message::false('Ошибка! Не удалось записать данные в БД');
                }
            }
        }
        
        // Список серверов
        $this->_data['server_list'] = $this->servers_model->get_servers_name();
        
        
        $this->_data['content'] = $this->users_model->get_user_info_by_id($user_id);;
        
        if($this->_data['content'])
        {
            $this->_data['groups']     = $this->get_user_group_name();
            $this->_data['group_name'] = $this->_data['groups'][$this->_data['content']['user_info']['group']];
        }

        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    public function add()
    {
        $this->_data['groups'] = $this->user_groups_model->get_groups_names();
        
        // Save
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            $this->form_validation->set_rules('login', 'Логин', 'trim|required|xss_clean|min_length[4]|max_length[20]|callback__check_user_login');
            $this->form_validation->set_rules('password', 'Пароль', 'trim|required|min_length[4]|max_length[20]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__check_user_email');
            $this->form_validation->set_rules('money', 'Денег', 'trim|required|integer');
            $this->form_validation->set_rules('group', 'Группа', 'trim|required|integer|callback__check_user_group');

            
            if($this->form_validation->run())
            {
                $this->load->helper('string');
                
                $data_db                  = elements($this->_data['field_data'], $this->input->post(), NULL);
                $data_db['joined']        = db_date();
                $data_db['password']      = $this->auth->password_encript($data_db['password']);
                $data_db['activated']     = '1';
                $data_db['referrer_link'] = random_string('alnum', 15);
                $data_db['login']         = $this->input->post('login', true);
                
                if($this->{$this->_model}->add($data_db))
                {
                    $this->_data['message'] = Message::true('Пользователь добавлен');
                }
                else
                {
                    $this->_data['message'] = Message::false('Ошибка! Не удалось записать данные в БД');
                }
            }
        }
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    /**
     * Активация аккаунта
     * 
     * @param integer $user_id
     */
    public function activated()
    {
        $user_id = (int) get_segment_uri(4);
        
        if($user_id < 1)
        {
            $this->session->set_flashdata('message', Message::false('Не выбран пользователь'));
            redirect('backend/users');
        }
        
        $data_db = array(
            'activated'           => '1',
            'activated_hash'      => NULL,
            'activated_hash_time' => NULL,
        );
        
        $data_db_where = array(
            'user_id' => $user_id,
        );
        
        if($this->users_model->edit($data_db, $data_db_where))
        {
            $this->session->set_flashdata('message', Message::true('Аккаунт активирован'));
        }
        else
        {
            $this->session->set_flashdata('message', Message::false('Ошибка! Обратитесь к Администрации сайта'));
        }
        
        redirect('backend/users');
    }
    
    /**
     * Бан/Разбан пользователя
     * 
     * @param integer $user_id
     * @param string $type
     * @param string $banned_reason
     */
    public function banned()
    {
        $user_id       = (int) get_segment_uri(4);
        $type          = get_segment_uri(5);
        $banned_reason = $this->input->post('banned_reason', true);
        
        
        if($user_id < 1)
        {
            $this->session->set_flashdata('message', Message::false('Не выбран пользователь'));
            redirect('backend/users');
        }

        $banned_reason = ($banned_reason == '' ? NULL : $banned_reason);

        $data_db = array(
            'banned'        => '1',
            'banned_reason' => $banned_reason,
            'cookie_hash'   => NULL,
        );
        
        $data_db_where = array(
            'user_id' => $user_id,
        );

        if($type == 'off')
        {
            $data_db['banned'] = '0';
            $data_db['banned_reason'] = NULL;
        }
        
        
        if($this->users_model->edit($data_db, $data_db_where))
        {
            $msg = 'Пользователь забанен';
            
            if($type == 'off')
            {
                $msg = 'Пользователь разбанен';
            }
            
            $this->session->set_flashdata('message', Message::true($msg));
        }
        else
        {
            $this->session->set_flashdata('message', Message::false('Ошибка! Обратитесь к Администрации сайта'));
        }
        
        redirect('backend/users');
    }
}