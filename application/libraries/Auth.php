<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auth
{
    private $_ci;
    
    /**
     * @var array: Массив с данными о пользователе
     */
    private $_user_data             = array();
    
    /**
     * @var string: Название таблицы с пользователями
     */
    private $_table                 = 'users';
    
    /**
     * @var integer: Время через которое юзер будет считаться оффлайн
     */
    private $_time_for_user_offline = 15;
    
    /**
     * @var integer: Время на сколько ставить куки, в днях
     */
    private $_cookie_time = 7;
    
    
    
    public function __construct()
    {
        $this->_ci =& get_instance();
        
        
        // Дефолтные значения
        $this->_user_data['is_logged'] = false;
        
        
        $cookie_data = $this->get_cookie();
        
        if(mb_strlen($cookie_data['cookie_hash']) == 32 && $cookie_data['user_id'] > 0)
        {
            $data_db_where = array(
                'user_id'     => $cookie_data['user_id'],
                'cookie_hash' => $cookie_data['cookie_hash'],
            );
            
            $this->_ci->db->where($data_db_where);
            $query = $this->_ci->db->get($this->_table, 1)->row_array();
            
            if($query)
            {
                $this->_user_data = $query;
                $this->_user_data['is_logged'] = true;
            }
            
            if($cookie_data['last_access'] < (time() - ($this->_time_for_user_offline * 60)))
            {
                $data_db = array(
                    'last_access' => db_date(),
                );

                $this->_ci->input->set_cookie('last_access', time(), 86400);
                $this->_ci->db->update($this->_table, $data_db, $data_db_where, 1);
            }
        }
    }
    
    public function set(array $data, $save_db = false)
    {
        foreach($data as $key => $val)
        {
           $this->_user_data[$key] = $val; 
        }
        
        if($save_db)
        {
            $data_db_where = array(
                'user_id' => $this->get('user_id'),
            );
            
            return $this->_ci->db->update($this->_table, $data, $data_db_where, 1);
        }
        
        return true;
    }
    
    public function get($key, $default = false)
    {
        return (isset($this->_user_data[$key]) ? $this->_user_data[$key] : $default);
    }
    
    public function get_all()
    {
        return $this->_user_data;
    }
    
    private function get_cookie()
    {
        $prefix = $this->_ci->config->item('cookie_prefix');
        
        $data = array(
            'user_id'     => (int) $this->_ci->input->cookie($prefix . 'user_id'),
            'cookie_hash' => $this->_ci->input->cookie($prefix . 'cookie_hash', true),
            'last_access' => (int) $this->_ci->input->cookie($prefix . 'last_access'),
        );
        
        return $data;
    }
    
    public function is_logged()
    {
        return $this->_user_data['is_logged'];
    }
    
    /**
     * Сверяет совпадения паролей
     * 
     * @param string $new_password: Пароль без шифрования
     * @param string $old_password: Зашифрованный пароль
     * 
     * @return boolean
     */
    public function check_passwords($new_password, $old_password)
    {
        return ($this->password_encript($new_password) == $old_password);
    }
    
    /**
     * Шифрует пароль
     * 
     * @param string $password
     * 
     * @return string
     */
    public function password_encript($password)
    {
        return md5(sha1($password));
    }
    
    /**
     * Авторизовывание пользователя
     * 
     * @param integer $user_id: ID пользователя который будет авторизован
     * 
     * @return boolean
     */
    public function auth($user_id)
    {
        $ip = $this->_ci->input->ip_address();
        
        $this->_ci->load->helper('string');
        
        $cookie_hash = md5($ip . random_string('alnum', 10));
        
        $this->_ci->input->set_cookie('user_id', $user_id, $this->_cookie_time * 86400);
        $this->_ci->input->set_cookie('cookie_hash', $cookie_hash, $this->_cookie_time * 86400);
        $this->_ci->input->set_cookie('last_access', time(), $this->_cookie_time * 86400);
        
        $data_db = array(
            'cookie_hash' => $cookie_hash,
            'last_access' => db_date(),
            'last_ip'     => $ip,
            'last_login'  => db_date(),
        );
        
        $data_db_where = array(
            'user_id' => $user_id,
        );
        
        return $this->_ci->db->update($this->_table, $data_db, $data_db_where, 1);
    }
    
    /**
     * Выход
     */
    public function logout()
    {
        $this->_user_data = array(
            'is_logged' => false,
        );
        
        $session_data = $this->get_cookie();
        
        $data_db = array(
            'cookie_hash' => NULL,
            'last_access' => NULL,
        );
        
        $data_db_where = array(
            'user_id'     => $session_data['user_id'],
            'cookie_hash' => $session_data['cookie_hash'],
        );
        
        $this->_ci->db->update($this->_table, $data_db, $data_db_where, 1);

        $this->_ci->input->set_cookie('user_id', '');
        $this->_ci->input->set_cookie('cookie_hash', '');
        $this->_ci->input->set_cookie('last_access', '');
    }
}