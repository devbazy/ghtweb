<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Logins_model extends Crud
{
    public $_table = 'logins';
    
    private $_fields = array(
        'name', 'ip', 'port', 'db_host', 'db_port', 'db_user', 'db_pass',
        'db_name', 'telnet_host', 'telnet_port', 'telnet_pass', 'version',
        'allow', 'password_type');
    
    public function get_fields()
    {
        return $this->_fields;
    }
    
    /**
     * Возвращает список логинов
     * 
     * @param boolean $only_allowed: Вернуть только включенные
     * 
     * @return array
     */
    public function get_logins_list($only_allowed = false)
    {
        if(!($res = $this->cache->get('settings_login')))
        {
            $res = $this->get_list();
            
            $this->cache->save('settings_login', $res);
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
     * Возвращает список логинов который включены и у них есть сервера
     * 
     * @return array
     */
    public function get_login_and_servers_name()
    {
        $res = $this->db->select('servers.`name`,servers.id')
            ->join('servers', 'logins.id = servers.login_id')
            ->where('logins.allow', '1')
            ->get($this->_table)
            ->result_array();
        
        $result = array();
        
        foreach($res as $row)
        {
            $result[$row['id']] = $row['name'];
        }
        
        return $result;
    }

    /**
     * Возвращает названия логинов
     *
     * @param boolean $only_allowed: Вернуть только включенные
     *
     * return array (login_id => login_name)
     */
    public function get_logins_name($only_allowed = false)
    {
        $res = $this->get_logins_list($only_allowed);

        $result = array();

        foreach($res as $row)
        {
            $result[$row['id']] = $row['name'];
        }

        return $result;
    }
}