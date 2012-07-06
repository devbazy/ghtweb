<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Lineage extends CI_Driver_Library
{
    public $valid_drivers = array();
    public $db = false; // ОБъект текущего подключения
    
    protected $_CI;
    
    private $_errors     = array(); // Ошибки
    private $_id;      // ID сервера/логина
    private $_type;    // Тип servers/logins
    private $_cache_db;    // Кэш объектов подключения к БД
    
    
    
    public function __construct()
    {
        $this->_CI =& get_instance();
        
        $drivers = $this->_CI->config->item('types_of_servers', 'lineage');
        
        foreach($drivers as $driver)
        {
            $this->valid_drivers[] = 'Lineage_' . $driver;
        }
    }
    
    /**
     * Подключение к БД
     * 
     * @param integer server_id|login_id
     * @param string servers|logins
     * 
     * @return object
     */
    private function _connect()
    {
        $id   = $this->_id;
        $type = ($this->_type == 'servers' ? 'servers' : 'logins');
        
        if(isset($this->_cache_db[$type][$id]))
        {
            $this->db = $this->_cache_db[$type][$id];
            return $this->db;
        }
        
        
        if(!isset($this->_CI->_l2_settings[$type][$id]))
        {
            $this->set_error(lang('Нет настроек для подключения к БД'));
            log_message('DEBUG', 'Нет настроек для подключения к БД<br />ID: ' . $id . '<br />Тип: ' . $type);
            return false;
        }
        
        $config = $this->_CI->_l2_settings[$type][$id];
        
        $db['hostname'] = $config['db_host'];
        $db['username'] = $config['db_user'];
        $db['password'] = $config['db_pass'];
        $db['database'] = $config['db_name'];
        $db['dbdriver'] = 'mysqli';
        $db['dbprefix'] = '';
        $db['pconnect'] = FALSE;
        $db['db_debug'] = FALSE;
        $db['cache_on'] = FALSE;
        $db['cachedir'] = '';
        $db['char_set'] = 'utf8';
        $db['dbcollat'] = 'utf8_general_ci';
        
        $link = $this->_CI->load->database($db, true);
        
        if(!is_object($link->conn_id))
        {
            $this->set_error(lang('Сервер не доступен'));
            log_message('DEBUG', 'Не удалось подключиться к БД <br />' . print_r($db, true));
            return false;
        }
        
        $this->db = $link;
        $this->_cache_db[$type][$id] = $link;
        unset($link);
        return $this->db;
    }
    
    /**
     * Создание игрового аккаунта
     * 
     * @param string $login
     * @param string $password
     * 
     * @return integer
     */
    public function insert_account($login, $password)
    {
        if(!($version = $this->get_version())) return false;
        
        if($this->_connect() == false) return false;
        
        return $this->{$version}->{__FUNCTION__}($login, $password);
    }

    /**
     * Возвращает данные аккаунта
     *
     * @param string $login
     *
     * @return array
     */
    public function get_account_by_login($login)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($login);
    }

    /**
     * Возвращает список аккаунтов
     *
     * @param mixed $login: логин
     * @param integer $limit
     * @param integer $offset
     *
     * @return array
     */
    public function get_accounts_by_login($login, $limit = NULL, $offset = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($login, $limit, $offset);
    }

    /**
     * Возвращает список аккаунтов
     *
     * @param integer $limit
     * @param integer $offset
     * @param array $where
     * @param string $order_by
     * @param string $order_type
     * @param array $like
     * @param array $group_by
     * @param string $where_in_field
     * @param array $where_in
     *
     * @return array
     */
    public function get_accounts($limit = NULL, $offset = NULL, array $where = NULL, $order_by = NULL, $order_type = 'asc', array $like = NULL, array $group_by = NULL, $where_in_field = NULL, array $where_in = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($limit, $offset, $where, $order_by, $order_type, $like, $group_by, $where_in_field, $where_in);
    }

    /**
     * Возвращает список персонажей, информацию о клане
     *
     * @param integer $limit
     * @param integer $offset
     * @param array $where
     * @param string $order_by
     * @param string $order_type
     * @param array $like
     * @param array $group_by
     * @param string $where_in_field
     * @param array $where_in
     *
     * @return array
     */
    public function get_characters($limit = NULL, $offset = NULL, array $where = NULL, $order_by = NULL, $order_type = 'asc', array $like = NULL, array $group_by = NULL, $where_in_field = NULL, array $where_in = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($limit, $offset, $where, $order_by, $order_type, $like, $group_by, $where_in_field, $where_in);
    }

    /**
     * Возвращает список персонажей, информацию о клане
     *
     * @param mixed $login: логин
     * @param integer $limit
     * @param integer $offset
     *
     * @return array
     */
    public function get_characters_by_login($login, $limit = NULL, $offset = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($login, $limit, $offset);
    }
    
    /**
     * Смена пароля от аккаунта
     * 
     * @param string $password
     * @param string $login
     * 
     * @return boolean
     */
    public function change_password_on_account($password, $login)
    {
        if(!($version = $this->get_version())) return false;
        
        if($this->_connect() == false) return false;
        
        return $this->{$version}->{__FUNCTION__}($password, $login);
    }
    
    /**
     * Возвращает данные о персонаже
     * 
     * @param integer $char_id
     * 
     * @return array
     */
    public function get_character_by_char_id($char_id)
    {
        if(!($version = $this->get_version())) return false;
        
        if($this->_connect() == false) return false;
        
        return $this->{$version}->{__FUNCTION__}($char_id);
    }

    /**
     * Изменяет координаты игроку
     *
     * @param array $data
     * @param integer $char_id
     *
     * @return boolean
     */
    public function change_coordinates($data, $char_id)
    {
        if(!($version = $this->get_version())) return false;
        
        if($this->_connect() == false) return false;
        
        return $this->{$version}->{__FUNCTION__}($data, $char_id);
    }

    /**
     * Добавляет предмет игроку
     *
     * @param integer $item_id
     * @param integer $count
     * @param integer $char_id
     * @param integer $enchant
     * @param string $loc
     *
     * @return boolean
     */
    public function insert_item($item_id, $count, $char_id, $enchant = 0, $loc = 'INVENTORY')
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($item_id, $count, $char_id, $enchant, $loc);
    }

    /**
     * Редактирует предмет игроку
     *
     * @param integer $object_id
     * @param integer $count
     * @param integer $char_id
     * @param integer $enchant
     * @param string $loc
     *
     * @return boolean
     */
    public function edit_item($object_id, $count, $char_id, $enchant = 0, $loc = 'INVENTORY')
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($object_id, $count, $char_id, $enchant, $loc);
    }

    /**
     * Удаление предмета
     *
     * @param mixed $item_id
     * @param integer $limit
     *
     * @return boolean
     */
    public function del_item($item_id, $limit = 1)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($item_id, $limit);
    }

    /**
     * Удаление всех предметов
     *
     * @param integer $owner_id
     *
     * @return boolean
     */
    public function del_items_by_owner_id($owner_id)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($owner_id);
    }

    /**
     * Возвращает предмет персонажа
     *
     * @param integer $char_id
     * @param integer $item_id
     *
     * @return boolean
     */
    public function get_character_item_by_item_id($char_id, $item_id)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($char_id, $item_id);
    }

    /**
     * Возвращает статус персонажа
     *
     * @param integer $char_id
     *
     * @return integer
     */
    public function get_online_status($char_id)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($char_id);
    }

    /**
     * Возвращает кол-во персонажей которые в игре, группирует по расе
     *
     * @return array
     */
    public function get_count_characters_online_group_race()
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}();
    }

    /**
     * Возвращает кол-во персонажей в игре
     *
     * @return integer
     */
    public function get_count_online()
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}();
    }

    /**
     * Возвращает кол-во аккаунтов
     *
     * @param array $where
     * @param array $like
     *
     * @return integer
     */
    public function get_count_accounts(array $where = NULL, array $like = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($where, $like);
    }

    /**
     * Возвращает кол-во персонажей
     *
     * @param array $where
     * @param array $like
     *
     * @return integer
     */
    public function get_count_characters(array $where = NULL, array $like = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($where, $like);
    }

    /**
     * Возвращает кол-во кланов
     *
     * @param array $where
     * @param array $like
     *
     * @return integer
     */
    public function get_count_clans(array $where = NULL, array $like = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($where, $like);
    }

    /**
     * Возвращает кол-во персонажей мужского пола
     *
     * @return integer
     */
    public function get_count_male()
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}();
    }

    /**
     * Возвращает кол-во персонажей женского пола
     *
     * @return integer
     */
    public function get_count_female()
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}();
    }

    /**
     * Возвращает кол-во рас
     *
     * @param integer $race_id
     *
     * @return integer
     */
    public function get_count_race_by_id($race_id)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($race_id);
    }

    /**
     * Возвращает кол-во рас, группирует по расе
     *
     * @return array
     */
    public function get_count_races_group_race()
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}();
    }

    /**
     * Возвращает ТОП ПВП персонажей
     *
     * @param integer $limit
     *
     * @return array
     */
    public function get_top_pvp($limit = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($limit);
    }

    /**
     * Возвращает ТОП ПК персонажей
     *
     * @param integer $limit
     *
     * @return array
     */
    public function get_top_pk($limit = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($limit);
    }

    /**
     * Возвращает ТОП кланы
     *
     * @param integer $limit
     *
     * @return array
     */
    public function get_top_clans($limit = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($limit);
    }

    /**
     * Возвращает ТОП персонажей в игре
     *
     * @param integer $limit
     *
     * @return array
     */
    public function get_top_online($limit = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($limit);
    }

    /**
     * Возвращает ТОП персонажей
     *
     * @param integer $limit
     *
     * @return array
     */
    public function get_top($limit = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($limit);
    }

    /**
     * Возвращает ТОП богачей
     *
     * @param integer $limit
     *
     * @return array
     */
    public function get_top_rich($limit = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($limit);
    }

    /**
     * Возвращает список замков
     *
     * @return array
     */
    public function get_castles()
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}();
    }

    /**
     * Возвращает всех кто записался на осаду замка
     *
     * @return array
     */
    public function get_siege()
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}();
    }

    /**
     * Возвращает Клан по его ID
     *
     * @param integer $clan_id
     *
     * @return array
     */
    public function get_clan_by_id($clan_id)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($clan_id);
    }

    /**
     * Возвращает персонажей по ID клана
     *
     * @param integer $clan_id
     * @param integer $limit
     *
     * @return array
     */
    public function get_characters_by_clan_id($clan_id, $limit)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($clan_id, $limit);
    }

    /**
     * Возвращает кол-во предметов персонажа
     *
     * @param integer $char_id
     *
     * @return integer
     */
    public function get_count_character_items($char_id)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($char_id);
    }

    /**
     * Возвращает предметы персонажа
     *
     * @param integer $limit
     * @param integer $offset
     * @param array $where
     * @param string $order_by
     * @param string $order_type
     * @param array $like
     * @param array $group_by
     * @param string $where_in_field
     * @param array $where_in
     *
     * @return array
     */
    public function get_character_items($limit = NULL, $offset = NULL, array $where = NULL, $order_by = NULL, $order_type = 'asc', array $like = NULL, array $group_by = NULL, $where_in_field = NULL, array $where_in = NULL)
    {
        if(!($version = $this->get_version())) return false;

        if($this->_connect() == false) return false;

        return $this->{$version}->{__FUNCTION__}($limit, $offset, $where, $order_by, $order_type, $like, $group_by, $where_in_field, $where_in);
    }





































































    // Setters    
    public function set_error($text)
    {
        $this->_errors = array();
        $this->_errors[] = $text;
    }
    
    public function set_id($id)
    {
        $this->_id = $id;
        return $this;
    }
    
    public function set_type($type)
    {
        $this->_type = $type;
        return $this;
    }
    
    // Getters
    public function get_id()
    {
        return $this->_id;
    }
    
    public function get_type()
    {
        return $this->_type;
    }
    
    public function get_errors()
    {
        if($this->db->_error_message())
        {
            return $this->db->_error_message();
        }

        return implode('<br />', $this->_errors);
    }
    
    public function get_version()
    {
        if(!isset($this->_CI->_l2_settings[$this->_type][$this->_id]['version']))
        {
            $this->set_error(lang('Логин сервер не найден'));
            return false;
        }
        
        return strtolower($this->_CI->_l2_settings[$this->_type][$this->_id]['version']);
    }
}