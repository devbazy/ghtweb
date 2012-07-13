<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users_warehouse_model extends Crud
{
    public $_table = 'users_warehouse';

    private $_fields = array('user_id', 'item_id', 'count', 'price');



    public function get_fields()
    {
        return $this->_fields;
    }

    public function insert(array $data_db)
    {
        return $this->db->insert_batch($this->_table, $data_db);
    }

    public function get_list($limit = 0, $offset = 0, array $where = NULL, $order_by = NULL, $order_type = 'ASC')
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
        
        $this->db->join('all_items', 'all_items.item_id = users_warehouse.item_id', 'left');
        
        return $this->db->get($this->_table)
            ->result_array();
    }

    public function get_row(array $where = NULL)
    {
        if($where != NULL)
        {
            $this->db->where($where);
        }

        $this->db->join('all_items', 'all_items.item_id = users_warehouse.item_id', 'left');

        return $this->db->get($this->_table, 1)
            ->row_array();
    }

    public function get_count($where)
    {
        $this->db->where($where);
        
        return $this->db->count_all_results($this->_table);
    }
}