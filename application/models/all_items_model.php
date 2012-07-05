<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class All_items_model extends Crud
{
    public $_table = 'all_items';
    
    private $_fields = array('item_id', 'name');
    
    
    
    public function get_fields()
    {
        return $this->_fields;
    }
    
    /**
     * LIKE поиск по имени
     * 
     * @param string $str 
     * 
     * @return array
     */
    public function search_item_by_name($str)
    {
        return $this->db->like('name', $str)
            ->order_by('name')
            ->get($this->_table)
            ->result_array();
    }

    public function get_list_where_in_by_id(array $where_in)
    {
        $this->db->where_in('item_id', $where_in);
        return $this->db->get($this->_table)
            ->result_array();
    }
}