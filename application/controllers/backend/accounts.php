<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Accounts extends Controllers_Backend_Base
{
    /**
     * @var array: Названия полей которые будут браться из $_GET для поиска
     */
    private $_search_fields = array('login');
    
    
    
    public function __construct()
    {
        parent::__construct();
        
        $class = strtolower(__CLASS__);
        $this->_view  = $class;
    }
    
    
	public function index()
	{
        $this->_data['server_list'] = $this->servers_model->get_servers_name();
        
        
        // Данные для страниицы
        $this->_data['content']    = array();
        $this->_data['pagination'] = '';
        $this->_data['count']      = 0;
        $this->_data['counter']    = 0;

        
        if($this->_data['server_list'])
        {
            $server_id = (isset($this->_data['server_list'][get_segment_uri(3)]) ? (int) get_segment_uri(3) : key($this->_data['server_list']));

            $server_config = $this->_l2_settings['servers'][$server_id];

            $login_id = $server_config['login_id'];
            
            
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
                ->set_id($login_id)
                ->set_type('logins');
            

            $count    = $this->lineage->get_count_accounts(NULL, $data_db_like);
            $per_page = (int) $this->config->item('accounts_per_page', 'backend');
            $page     = (int) $this->input->get('per_page');
            
            // Пагинация
            $this->load->library('pagination');
            
            $this->pagination->initialize(array(
                'total_rows' => $count,
                'per_page'   => $per_page,
            )); 
            
            $this->_data['pagination'] = $this->pagination->create_links();
            $this->_data['content']    = $this->lineage->get_accounts($per_page, $page, NULL, 'login', NULL, $data_db_like);
            $this->_data['server_id']  = $server_id;
            $this->_data['count']      = $count;
        }
        else
        {
            $this->_data['message'] = Message::info('Серверов нет');
        }
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
}