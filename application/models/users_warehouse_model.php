<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users_warehouse_model extends Crud
{
    public $_table = 'users_warehouse';

    private $_fields = array('user_id', 'product_id');



    public function get_fields()
    {
        return $this->_fields;
    }

    public function insert(array $data_db)
    {
        return $this->db->insert_batch($this->_table, $data_db);
    }

    public function get_list_for_warehouse($limit = 0, $offset = 0, $user_id, $item_id)
    {
        if($offset > 0)
        {
            $this->db->limit($offset, $limit);
        }

        $this->db->where('user_id', $user_id);
        $this->db->where('moved_to_game', '0');
        $this->db->or_where('sent_gift_to', $user_id);


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

        if(isset($where['sent_gift_to']))
        {
            $this->db->or_where('sent_gift_to', $where['sent_gift_to']);
        }

        $this->db->select('users_warehouse.product_id,shop_products.item_id,shop_products.price,shop_products.count,shop_products.date_start,shop_products.date_stop,shop_products.description,shop_products.category_id,
            shop_products.created,shop_products.enchant_level,shop_products.item_type,shop_categories.`name` AS category_name,all_items.`name` AS item_name,all_items.crystal_type as grade,users_warehouse.id', false);


        $this->db->join('shop_products', 'users_warehouse.product_id = shop_products.id', 'left');
        $this->db->join('shop_categories', 'shop_products.category_id = shop_categories.id', 'left');
        $this->db->join('all_items', 'shop_products.item_id = all_items.item_id', 'left');

        return $this->db->get($this->_table)
            ->result_array();
    }

    public function get_row(array $where = NULL)
    {
        if($where != NULL)
        {
            $this->db->where($where);
        }

        $this->db->select('users_warehouse.product_id,shop_products.item_id,shop_products.price,shop_products.count,shop_products.date_start,shop_products.date_stop,shop_products.description,shop_products.category_id,
            shop_products.created,shop_products.enchant_level,shop_products.item_type,shop_categories.`name` AS category_name,all_items.`name` AS item_name,all_items.crystal_type as grade,users_warehouse.id', false);


        $this->db->join('shop_products', 'users_warehouse.product_id = shop_products.id', 'left');
        $this->db->join('shop_categories', 'shop_products.category_id = shop_categories.id', 'left');
        $this->db->join('all_items', 'shop_products.item_id = all_items.item_id', 'left');

        return $this->db->get($this->_table, 1)
            ->row_array();
    }

    public function get_count($where)
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->_table);
    }
}