<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users_gifts_model extends Crud
{
    public $_table = 'users_gifts';
    
    private $_fields = array('from', 'to', 'item_id', 'count', 'price');
    
    
    
    public function get_fields()
    {
        return $this->_fields;
    }
    
    
    
    /**
     * Возвращает все подарки
     * 
     * @param integer $limit
     * @param integer $offset
     * @param array $where
     * @param string $order_by
     * @param string $order_type
     * 
     * @return array
     */
    public function get_list($limit = 0, $offset = 0)
    {
        $this->db->select('all_items.`name`,users.login,users_gifts.id,users_gifts.item_id,users_gifts.count');
        
        // Limit
        if($offset > 0)
        {
            $this->db->limit($offset, $limit);
        }

        $this->db->order_by($this->_table . '.date', 'DESC');
        
        $this->db->where('to', $this->auth->get('user_id'));
        $this->db->where('status', '0');
        
        $this->db->join('all_items', $this->_table . '.item_id = all_items.item_id', 'left');
        
        // Логин отправителя
        $this->db->join('users', $this->_table . '.from = users.user_id', 'left');
        
        return $this->db->get($this->_table)
            ->result_array();
    }
}