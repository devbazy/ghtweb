<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Settings_model extends Crud
{
    public $_table = 'settings';
    
    
    /**
     * Сохранение настроек
     * 
     * @param array $data
     * 
     * @return boolean
     */
    public function edit_settings(array $data)
    {
        foreach($data as $k => $v)
        {
            $data_db = array(
                'value' => $v,
            );
            
            $data_db_where = array(
                'key' => $k,
            );
            
            $this->db->update($this->_table, $data_db, $data_db_where, 1);
        }
        
        return true;
    }
    
    /**
     * Возвращает список настроек
     * 
     * @param integer $group_id: ID группы
     *
     * @return array
     */
    public function get_settings_by_group_id($group_id)
    {
        $this->db->where('group_id', $group_id);
        $settings = $this->db->get($this->_table)->result_array();
        $server_list = $this->servers_model->get_servers_name();


        foreach($settings as $key => $val)
        {
            // Шаблоны сайта
            if($val['key'] == 'template')
            {
                $settings[$key]['param'] = get_templates();
            }
            // ID сервера по которому генерится файл online.txt
            elseif($val['key'] == 'server_id_for_online_txt')
            {
                $settings[$key]['param'] = $server_list;
            }
            // Дефолтная страница
            elseif($val['key'] == 'home_page_name')
            {
                $this->load->model('pages_model');
                
                $settings[$key]['param'] = $this->pages_model->get_page_titles();
            }
            // ТОП ПВП/ПК
            elseif($val['key'] == 'top_pvp_server_id' || $val['key'] == 'top_pk_server_id')
            {
                $settings[$key]['param'] = $server_list;
            }
            else
            {
                if($val['param'] != '')
                {
                    $param = explode(',', $val['param']);
                    
                    if(is_array($param))
                    {
                        $settings[$key]['param'] = array_combine(array_values($param), $param);
                    }
                }
            }
        }
        
        return $settings;
    }
    
    /**
     * Возвращает список настроек, KEY - ключи, VALUE - значения
     * 
     * @return array
     */
    public function get_settings_list()
    {
        if(!($content = $this->cache->get('site_settings')))
        {
            $res = $this->get_list();

            $content = array();

            foreach($res as $row)
            {
                $content[$row['key']] = $row['value'];
            }
            
            $this->cache->save('site_settings', $content);
        }
        
        return $content;
    }
}