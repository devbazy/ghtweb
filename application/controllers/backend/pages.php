<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pages extends Controllers_Backend_Base
{
    /**
     * @var array: Названия полей которые будут браться из $_GET для поиска
     */
    private $_search_fields = array('title', 'page', 'lang');
    
    
    
    public function __construct()
    {
        parent::__construct();

        $class = strtolower(__CLASS__);
        $this->_model = $class . '_model';
        $this->_view  = $class;  
        
        $this->load->model($this->_model);
        
        $this->_data['field_data'] = $this->{$this->_model}->get_fields();
    }
    
    public function index()
    {
        $per_page = (int) $this->config->item('pages_per_page', 'backend');
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
        
        
        $this->_data['content']  = $this->{$this->_model}->get_list($page, $per_page, NULL, 'date', 'DESC', $data_db_like);
        $this->_data['count']    = $count;
        $this->_data['per_page'] = $per_page;
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    public function edit()
    {
        $id = (int) get_segment_uri(4);
        
        if($id < 1)
        {
            redirect('backend/' . $this->_view);
        }
        
        $data_db_where = array(
            'id' => $id
        );
        
        
        // Save
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            if($this->form_validation->run('backend_pages'))
            {
                $data_db                     = elements($this->_data['field_data'], $this->input->post(), NULL);
                $data_db['date_last_change'] = db_date();
                
                if($this->{$this->_model}->edit($data_db, $data_db_where, 1))
                {
                    $page_data = $this->{$this->_model}->get_row($data_db_where);
                    
                    $this->cache->delete('pages/' . $page_data['page'] . '_' . $page_data['lang']);
                    $this->cache->delete('page_in_menu');

                    $this->_data['message'] = Message::true('Страница сохранена');
                }
                else
                {
                    $this->_data['message'] = Message::false('Ошибка! Не удалось записать данные в БД');
                }
            }
        }
        
        
        $this->_data['content'] = $this->{$this->_model}->get_row($data_db_where);
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    public function add()
    {
        // Save
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            if($this->form_validation->run('backend_pages'))
            {

                $data_db         = elements($this->_data['field_data'], $this->input->post(), NULL);
                $data_db['date'] = db_date();

                if($this->{$this->_model}->add($data_db))
                {
                    $this->_data['message'] = Message::true('Страница добавлена');
                    $this->cache->delete('page_in_menu');
                }
                else
                {
                    $this->_data['message'] = Message::false('Ошибка! Не удалось записать данные в БД');
                }
            }
        }
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    public function del()
    {
        $id = (int) get_segment_uri(4);
        
        if($id < 1)
        {
            redirect('backend/' . $this->_view);
        }
        
        $data_db_where = array(
            'id' => $id
        );
        
        $page_data = $this->{$this->_model}->get_row($data_db_where);
        
        if($page_data)
        {
            $this->{$this->_model}->del($data_db_where, 1);
            
            $this->cache->delete('pages/' . $page_data['page'] . '_' . $page_data['lang']);
            $this->cache->delete('page_in_menu');
        }
        
        $this->session->set_flashdata('message', Message::true('Страница удалена'));
        redirect('backend/' . $this->_view);
    }
    
    public function stop()
    {
        $id = (int) get_segment_uri(4);
        
        if($id < 1)
        {
            redirect('backend/' . $this->_view);
        }
        
        $allow = (get_segment_uri(5) == 'off' ? '0' : '1');
        
        $data_db_where = array(
            'id' => $id
        );
        
        
        $page_data = $this->{$this->_model}->get_row($data_db_where);
        
        if($page_data)
        {
            $data_db = array(
                'allow' => $allow,
            );
        
            $this->{$this->_model}->edit($data_db, $data_db_where);
            
            $this->cache->delete('pages/' . $page_data['page'] . '_' . $page_data['lang']);
            $this->cache->delete('page_in_menu');
        }
        
        $this->session->set_flashdata('message', Message::true('Страница ' . ($allow == 1 ? 'включена' : 'отключена')));
        redirect('backend/' . $this->_view);
    }
}