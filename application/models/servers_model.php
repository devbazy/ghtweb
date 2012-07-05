<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Servers_model extends Crud
{
    public $_table = 'servers';
    
    private $_fields = array(
        'name', 'ip', 'port', 'db_host', 'db_port', 'db_user', 'db_pass',
        'db_name', 'telnet_host', 'telnet_port', 'telnet_pass', 'login_id',
        'version', 'allow', 'fake_online', 'allow_teleport', 'teleport_time',
        'stats_allow', 'stats_cache_time', 'stats_total', 'stats_pvp', 'stats_pk', 'stats_clans',
        'stats_castles', 'stats_online',
        'stats_clan_info', 'stats_top', 'stats_rich', 'stats_count_results',
        'exp', 'sp', 'adena', 'items', 'spoil', 'q_drop', 'q_reward', 'rb', 'erb');
    
    public function get_fields()
    {
        return $this->_fields;
    }
    
    
    /**
     * Выборка по параметрам
     * 
     * @param integer $limit
     * @param integer $offset
     * @param array $where
     * @param string $order_by
     * @param string $order_type
     * @param array $like
     * 
     * @return array
     */
    public function get_list($limit = 0, $offset = 0, array $where = NULL, $order_by = NULL, $order_type = 'ASC', array $like = NULL)
    {
        // Limit
        if($offset > 0)
        {
            $this->db->limit($offset, $limit);
        }
        
        // Order by
        if($order_by != NULL)
        {
            $this->db->order_by($order_by, $order_type);
        }
        
        // Where
        if($where != NULL)
        {
            $this->db->where($where);
        }
        
        // Like
        if($like != NULL)
        {
            $this->db->like($like);
        }
        
        $this->db->select('servers.*, logins.name AS login_name');
        $this->db->join('logins', 'servers.login_id = logins.id', 'left');
        
        return $this->db->get($this->_table)
            ->result_array();
    }
    
    /**
     * Возвращает список серверов
     * 
     * @param boolean $only_allowed: Вернуть только включенные
     * 
     * @return array
     */
    public function get_servers_list($only_allowed = false)
    {
        if(!($res = $this->cache->get('settings_server')))
        {
            $res = $this->get_list();
            
            $this->cache->save('settings_server', $res);
        }
        
        $result = array();
        
        if($res)
        {
            foreach($res as $row)
            {
                if($only_allowed === true && $row['allow'] == 0)
                {
                    continue;
                }
                
                $result[$row['id']] = $row;
            }
        }
        
        return $result;
    }
    
    /**
     * Возвращает названия серверов
     * 
     * @param boolean $only_allowed: Вернуть только включенные
     * 
     * return array (server_id => server_name)
     */
    public function get_servers_name($only_allowed = false)
    {
        $res = $this->get_servers_list($only_allowed);
        
        $result = array();
        
        foreach($res as $row)
        {
            $result[$row['id']] = $row['name'];
        }
        
        return $result;
    }
}