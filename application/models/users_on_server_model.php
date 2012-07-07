<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users_on_server_model extends Crud
{
    public $_table = 'users_on_server';
    
    
    /**
     * Возвращает массив аккаунтов в зависимости от ID юзера
     *
     * @param integer $user_id
     *
     * @return array
     */
    public function get_accounts_by_user_id($user_id, $server_id = 0)
    {
        $data_db_where = array(
            'user_id' => $user_id,
        );
        
        if((int) $server_id > 0)
        {
            $data_db_where['server_id'] = $server_id;
        }
        
        $data = $this->get_list(0, 0, $data_db_where);
        
        $accounts = array();
        
        foreach($data as $row)
        {
            if(!in_array($row['server_account_name'], $accounts))
            {
                $accounts[] = $row['server_account_name'];
            }
        }
        
        return $accounts;
    }

    /**
     * Возвращает список аккаунтов и серверов которым они принадлежат
     *
     * @param integer $user_id
     *
     * @return array
     */
    public function get_accounts_and_servers($user_id)
    {
        $this->db->select('servers.name,' . $this->_table . '.*');
        $this->db->where('user_id', $user_id);
        $this->db->join('servers', 'servers.id = ' . $this->_table . '.server_id', 'left');
        return $this->db->get($this->_table)
            ->result_array();
    }

    /**
     * Возвращает кол-во аккаунтов пользователя, учитывается вкл или выкл сервер
     *
     * @param array $where
     *
     * @return integer
     */
    public function get_count_accounts($user_id)
    {
        $this->db->select('id,(SELECT COUNT(0) FROM `users_on_server` WHERE `user_id` = ' . (int) $user_id . ' AND server_id = servers.id) as count');
        $this->db->where('allow', '1');
        $res = $this->db->get('servers')
            ->result_array();

        $count = 0;

        foreach($res as $row)
        {
            $count += $row['count'];
        }

        return $count;
    }
}
