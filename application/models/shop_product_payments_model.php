<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Shop_product_payments_model extends Crud
{
    public $_table = 'shop_product_payments';
    
    private $_fields = array('user_id', 'shop_item_id', 'user_ip');
    
    
    
    public function get_fields()
    {
        return $this->_fields;
    }
    
    public function get_count(array $where = NULL, array $like = NULL)
    {
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

        $this->db->join('shop_products', 'shop_product_payments.shop_item_id = shop_products.id', 'left');
        $this->db->join('shop_categories', 'shop_products.category_id = shop_categories.id', 'left');
        $this->db->join('all_items', 'shop_products.item_id = all_items.item_id', 'left');
        $this->db->join('users', 'shop_product_payments.user_id = users.user_id', 'left');
        
        return $this->db->count_all_results($this->_table);
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
        
        $this->db->select('shop_product_payments.id,shop_products.item_id,shop_products.price,shop_products.count,shop_products.date_start,shop_products.date_stop,shop_products.description,shop_products.category_id,users.login,shop_product_payments.user_id,
            shop_categories.`name` AS category_name,shop_products.created,shop_products.enchant_level,shop_products.item_type,shop_product_payments.user_ip,shop_product_payments.date,all_items.`name` AS item_name,all_items.crystal_type AS grade');

        $this->db->join('shop_products', 'shop_product_payments.shop_item_id = shop_products.id', 'left');
        $this->db->join('shop_categories', 'shop_products.category_id = shop_categories.id', 'left');
        $this->db->join('all_items', 'shop_products.item_id = all_items.item_id', 'left');
        $this->db->join('users', 'shop_product_payments.user_id = users.user_id', 'left');

        return $this->db->get($this->_table)
            ->result_array();
    }
    
    public function insert_batch($array)
    {
        return $this->db->insert_batch($this->_table, $array);
    }
    
    /**
     * Список проданных товаров
     * Посчитана сумма за каждый товар
     * 
     * @return array
     */
    public function get_sales_products()
    {
        return $this->db->select('shop_product_payments.date,shop_products.item_id,all_items.`name` AS item_name,Sum(shop_products.count) AS count,Sum(shop_products.price) AS sum')
            ->join('shop_products', 'shop_product_payments.shop_item_id = shop_products.id', 'left')
            ->join('all_items', 'shop_products.item_id = all_items.item_id', 'left')
            ->group_by('shop_products.item_id')
            ->get($this->_table)
            ->result_array();
    }
    
    /**
     * Список проданных товаров
     * Формирует данные для графика
     *
     * @return array
     */
    public function get_sales_products_for_graph()
    {
        $data = $this->get_sales_products();
        
        $result = array();
        
        if($data)
        {
            foreach($data as $row)
            {
                $result['name'][]    = $row['item_name'];
                $result['item_id'][] = $row['item_id'];
                $result['count'][]   = $row['count'];
                $result['sum'][]     = $row['sum'];
            }
        }
        
        return $result;
    }
}