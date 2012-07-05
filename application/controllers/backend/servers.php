<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Servers extends Controllers_Backend_Base
{
    public function __construct()
    {
        parent::__construct();
        
        $class = strtolower(__CLASS__);
        $this->_model = $class . '_model';
        $this->_view  = $class;
        
        $this->load->model($this->_model);
        
        $this->_data['field_data'] = $this->{$this->_model}->get_fields();
        
        // Список логин серверов
        $this->_data['login_list'] = $this->logins_model->get_logins_name();
        
        // Список поддерживаемых версий
        $this->_data['version_list'] = $this->config->item('types_of_servers', 'lineage');
    }
    
    public function index()
    {
        $per_page = (int) $this->config->item('servers_per_page', 'backend');
        $page     = (int) $this->input->get('per_page');
        
        $count = $this->{$this->_model}->get_count();
        
        // Пагинация
        $this->load->library('pagination');

        $this->pagination->initialize(array(
            'total_rows' => $count,
            'per_page'   => $per_page,
        ));
        
        $this->_data['pagination'] = $this->pagination->create_links();
        $this->_data['content']    = $this->{$this->_model}->get_list($page, $per_page, NULL, 'servers.allow', 'DESC');
        $this->_data['count']      = $count;
        
        
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

        $this->cache->delete('settings_server');
        $this->cache->delete('server_status');
        $this->cache->delete('top_pvp');
        $this->cache->delete('top_pk');
        $this->cache->delete('stats/*_' . $id);
        
        $this->session->set_flashdata('message', Message::true('Сервер удален'));
        redirect('backend/' . $this->_view);
    }

    public function add()
    {
        // Save
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            if($this->form_validation->run('backend_servers'))
            {
                $data_db            = elements($this->_data['field_data'], $this->input->post(), NULL);
                $data_db['created'] = db_date();
                
                if($this->{$this->_model}->add($data_db))
                {
                    $this->cache->delete('settings_server');
                    $this->cache->delete('server_status');
                    $this->cache->delete('top_pvp');
                    $this->cache->delete('top_pk');
                    $this->cache->delete('stats/*');

                    $this->_data['message'] = Message::true('Сервер добавлен');
                }
                else
                {
                    $this->_data['message'] = Message::false('Ошибка! Не удалось записать данные в БД');
                }
            }
        }
        
        
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
            
            if($this->form_validation->run('backend_servers'))
            {
                $data_db = elements($this->_data['field_data'], $this->input->post(), NULL);
                
                if($this->{$this->_model}->edit($data_db, $data_db_where, 1))
                {
                    $this->_data['message'] = Message::true('Изменения сохранены');

                    $this->cache->delete('settings_server');
                    $this->cache->delete('server_status');
                    $this->cache->delete('top_pvp');
                    $this->cache->delete('top_pk');
                    $this->cache->delete('stats/*_' . $id);
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
    
    public function _check_login_by_id()
    {
        if(!array_key_exists($this->input->post('login_id'), $this->_data['login_list']))
        {
            $this->form_validation->set_message('_check_login_id', lang('Логин не существует'));
            return false;
        }
        
        return true;
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
        
        $this->cache->delete('settings_server');
        $this->cache->delete('server_status');
        $this->cache->delete('top_pvp');
        $this->cache->delete('top_pk');
        $this->cache->delete('stats/*_' . $id);

        
        $this->session->set_flashdata('message', Message::true('Сервер ' . ($allow == 1 ? 'включен' : 'отключен')));
        redirect('backend/' . $this->_view);
    }
}