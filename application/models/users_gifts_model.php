<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users_gifts_model extends Crud
{
    public $_table = 'users_gifts';

    private $_fields = array('to', 'from');



    public function get_fields()
    {
        return $this->_fields;
    }

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

        $this->db->select('users_gifts.`id`,users_gifts.`to`,users.login,users_gifts.`from`,shop_products.count,shop_products.enchant_level,shop_products.item_id,all_items.`name`,users_gifts.shop_item_id,all_items.crystal_type AS grade', false);

        $this->db->join('shop_products', 'users_gifts.shop_item_id = shop_products.id', 'left');
        $this->db->join('users', 'users_gifts.from = users.user_id', 'left');
        $this->db->join('all_items', 'shop_products.item_id = all_items.item_id', 'left');

        return $this->db->get($this->_table)
            ->result_array();
    }
}