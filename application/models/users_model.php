<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users_model extends Crud
{
    public $_table = 'users';
    
    private $_fields = array('password', 'email', 'money', 'protected_ip', 'group');
    
    
    
    public function get_fields()
    {
        return $this->_fields;
    }
    
    /**
     * Поиск пользователя по login или email
     * 
     * @param string $login
     * @param string $email
     *
     * @return array
     */
    public function get_user_by_login_or_email($login, $email)
    {
        $this->db->where('login', $login);
        $this->db->or_where('email', $email);
        
        return $this->db->get($this->_table, 1)->row_array();
    }

    /**
     * Возвращает все данные о пользователю по его ID
     * Данные пользователя
     * Данные об его аккаунтах
     * Название серверов
     *
     * @param integer $user_id
     *
     * @return array
     */
    public function get_user_info_by_id($user_id)
    {
        $data = array(
            'user_info'     => array(), // Информация о пользователе
            'accounts_info' => array(), // Информация о его аккаунтах
        );


        $data_db_where = array(
            'user_id' => $user_id,
        );

        // Информация о пользователе
        $data['user_info'] = $this->get_row($data_db_where);

        // Аккаунты
        $accounts = array();

        // Информация о его аккаунтах
        $this->db->select('users_on_server.server_account_name,users_on_server.server_id');
        $this->db->where('users_on_server.user_id', $user_id);
        $this->db->order_by('server_account_name');
        $accounts_info = $this->db->get('users_on_server')
            ->result_array();

        foreach($accounts_info as $row)
        {
            $data['accounts_info'][$row['server_id']][] = $row['server_account_name'];
        }


        // Достаю персонажей с серверов
        /*$server_characters = array();

        foreach($accounts as $server_id => $acc)
        {
            $server_characters[$server_id] = $this->lineage->get_characters_list_by_logins($server_id, $acc);
        }

        unset($accounts, $server_id, $acc);


        // Собираю массивы в один
        $final_accounts_info = array();

        foreach($data['accounts_info'] as $server_id => $acc)
        {
            if(isset($server_characters[$server_id]))
            {
                foreach($server_characters[$server_id] as $row)
                {
                    $final_accounts_info[$server_id][$row['account_name']][] = $row;
                }
            }
        }

        $data['accounts_info'] = $final_accounts_info;*/

        return $data;
    }
}