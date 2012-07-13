<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Shop extends Controllers_Backend_Base
{
    public function __construct()
    {
        parent::__construct();
        
        $class = strtolower(__CLASS__);
        $this->_model = 'shop_products_model';
        $this->_view  = $class;  
        
        $this->load->model($this->_model);

        $this->_data['field_data'] = $this->{$this->_model}->get_fields();
    }
    
    public function index()
    {
        $per_page = (int) $this->config->item('shop_per_page', 'backend');
        $page     = (int) $this->input->get('per_page');
        
        
        $count = $this->{$this->_model}->get_count();
        
        // Пагинация
        $this->load->library('pagination');
        
        $this->pagination->initialize(array(
            'total_rows' => $count,
            'per_page'   => $per_page,
        ));
        
        $this->_data['pagination'] = $this->pagination->create_links();
        
        
        $this->_data['content']  = $this->{$this->_model}->get_list($page, $per_page, NULL, 'created', 'DESC');
        $this->_data['count']    = $count;
        $this->_data['per_page'] = $per_page;
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    /**
     * Статистика по товарам
     */
    public function stats()
    {
        $this->load->model('shop_product_payments_model');
        
        $per_page = (int) $this->config->item('shop_stats_per_page', 'backend');
        $page     = (int) $this->input->get('per_page');
        
        
        $data_db_like = array();
        
        $search_fields = array('item_id' => 'shop_product_payments.item_id', 'login' => 'users.login', 'price' => 'shop_product_payments.price');
        
        // Поиск
        if($this->input->get())
        {
            $get = $this->input->get();
            
            foreach($get as $key => $val)
            {
                $val = trim($val);
                
                if(isset($search_fields[$key]) && $val != '')
                {
                    $key = ($search_fields[$key] != '' ? $search_fields[$key] : $key);
                    $data_db_like[$key] = $val;
                }
            }
        }
        
        $count = $this->shop_product_payments_model->get_count(NULL, $data_db_like);
        
        // Пагинация
        $this->load->library('pagination');

        $this->pagination->initialize(array(
            'total_rows' => $count,
            'per_page'   => $per_page,
        )); 

        $this->_data['pagination'] = $this->pagination->create_links();
        
        
        $this->_data['content']  = $this->shop_product_payments_model->get_list($page, $per_page, NULL, 'date', 'DESC', $data_db_like);
        $this->_data['count']    = $count;
        $this->_data['per_page'] = $per_page;
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    /**
     * Статистика продаж по товарам
     */
    public function stats_sales_products()
    {
        $this->load->model('shop_product_payments_model');
        
        $this->_data['graph_sales_products'] = $this->shop_product_payments_model->get_sales_products_for_graph();
        
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
        
        
        $this->_data['categories'] = $this->get_shop_categories();

        // Тип предмета
        $this->_data['item_type'] = array('stock', 'no_stock');

        // Save
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            if($this->form_validation->run('backend_shop_product'))
            {
                $data_db = elements($this->_data['field_data'], $this->input->post(), NULL);
                
                if($this->{$this->_model}->edit($data_db, $data_db_where, 1))
                {
                    $this->_data['message'] = Message::true('Товар сохранен');
                }
                else
                {
                    $this->_data['message'] = Message::false('Ошибка! Не удалось записать данные в БД');
                }
            }
        }
        
        
        $this->_data['content'] = $this->{$this->_model}->get_product($data_db_where);
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    public function add()
    {
        // Категории
        $this->_data['categories'] = $this->get_shop_categories();

        // Тип предмета
        $this->_data['item_type'] = array('stock', 'no_stock');
        
        
        // Save
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            if($this->form_validation->run('backend_shop_product'))
            {
                $data_db = elements($this->_data['field_data'], $this->input->post(), NULL);
                
                $data_db['price']   = (float) $data_db['price'];
                $data_db['created'] = db_date();
                
                if($this->{$this->_model}->add($data_db))
                {
                    $this->_data['message'] = Message::true('Товар добавлен');
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
        
        $this->{$this->_model}->del($data_db_where, 1);
        
        $this->session->set_flashdata('message', Message::true('Товар удален'));
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
        
        $data_db = array(
            'allow' => $allow,
        );
        
        $this->{$this->_model}->edit($data_db, $data_db_where);
        
        $this->session->set_flashdata('message', Message::true('Товар ' . ($allow == 1 ? 'включен' : 'отключен')));
        redirect('backend/' . $this->_view);
    }
    
    /**
     * Возвращает список категорий
     * 
     * @return array
     */
    private function get_shop_categories()
    {
        $this->load->model('shop_categories_model');
        
        $data_db_where = array(
            'allow' => '1'
        );
        
        $res = $this->shop_categories_model->get_list(0, 0, $data_db_where, 'name');
        
        $categories = array();
        
        foreach($res as $row)
        {
            $categories[$row['id']] = $row['name'];
        }
        
        return $categories;
    }

    /**
     * Проверка типа предмета
     *
     * @return boolean
     */
    public function _check_item_type()
    {
        if($this->input->post('item_type') != 'stock' && $this->input->post('item_type') != 'no_stock')
        {
            $this->form_validation->set_message('_check_item_type', 'Тип предмета выбран не верно');
            return false;
        }

        return true;
    }
    
    /**
     * Проверяет категорию
     * 
     * @return boolean
     */
    public function _check_categories()
    {
        if(!isset($this->_data['categories'][(int) $this->input->post('category_id')]))
        {
            $this->form_validation->set_message('_check_categories', 'Выбранная категория не существует');
            return false;
        }
        
        return true;
    }
    
    /**
     * 
     */
    public function search_item_by_name()
    {
        if(!$this->input->is_ajax_request())
        {
            die;
        }
        
        $value = $this->input->post('value', true);
        
        if(mb_strlen($value) > 2)
        {
            $this->load->model('all_items_model');
            
            $this->_ajax_data['message'] = $this->all_items_model->search_item_by_name($value);
        }
        
        die(json_encode($this->_ajax_data));
    }
}