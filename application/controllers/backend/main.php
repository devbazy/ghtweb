<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Main extends Controllers_Backend_Base
{
	public function index()
	{
        // Размер БД
        $query = $this->db->query('SHOW TABLE STATUS');
        
        $length_bd = 0;
        
        if(is_object($query))
        {
            $query = $query->result_array();
            
            foreach($query as $row)
            {
                $length_bd += $row['Data_length'];
            }
        }
        
        $this->load->helper('number');
        
        $this->_data['length_bd'] = byte_format($length_bd);
        
        unset($query, $length_bd);        
        
        
        // Размер кэша
        $this->load->helper('file');
        
        $files_scan = get_dir_file_info(FCPATH . 'application/cache/');
        
        $size = 0;
        
        foreach($files_scan as $key => $val)
        {
            if($key != 'index.html' && $key != '.htaccess')
            {
                $size += $val['size'];
            }
        }
        
        $this->_data['cache_size'] = byte_format($size);
        
        unset($files_scan, $size);
        

        // Кол-во регистраций
        $this->_data['users_count_register'] = $this->db->count_all('users');
        
        // Кол-во регистраций за последнии 30 дней
        $this->db->where('UNIX_TIMESTAMP(joined) > UNIX_TIMESTAMP(NOW()) - 2592000');
        $this->_data['users_count_register_last_30_dey'] = $this->db->count_all_results('users');
        
        // Не активированных регистраций
        $this->db->where('activated', '0');
        $this->_data['users_count_not_activated'] = $this->db->count_all_results('users');
        
        // Кол-во регистраций за последнии 7 дней
        $this->db->where('UNIX_TIMESTAMP(joined) > UNIX_TIMESTAMP(NOW()) - 604800');
        $this->_data['users_count_register_last_7_day'] = $this->db->count_all_results('users');
        
         // Забаненые
        $this->db->where('banned', '1');
        $this->_data['users_count_banned'] = $this->db->count_all_results('users');

        
        
        // Данные для графика по регистрациям
        $this->graph_data();
        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
    
    private function graph_data()
    {
        $data = $this->db->select('joined as date, COUNT(0) as count')
                         ->group_by('DAY(joined)')
                         ->order_by('joined')
                         ->get('users')
                         ->result_array();
        
        $time = array();
        $count = array();
        
        foreach($data as $row)
        {
            $time[]  = substr($row['date'], 0, 10);
            $count[] = $row['count'];
        }
        
        $this->_data['reg_data_time'] = "['" . join("','", $time) . "']";
        $this->_data['reg_data_count'] = "[" . join(",", $count) . "]";
    }
    
    /**
     * Очистка кэша
     */
    public function clear_cache()
    {
        $cache_path = APPPATH . 'cache/';
        
        $f = array();
        
        foreach(glob($cache_path . '*') as $file)
        {
            if($file == 'index.html' || $file == '.htaccess' || $file == 'htaccess')
            {
                continue;
            }
            
            unlink(FCPATH . $file);
        }
        
        die(json_encode(true));
    }
}