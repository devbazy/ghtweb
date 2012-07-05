<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Shop_product_payments_model extends Crud
{
    public $_table = 'shop_product_payments';
    
    private $_fields = array('user_id', 'item_id', 'count', 'price', 'user_ip');
    
    
    
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
        
        $this->db->join('all_items', '' . $this->_table . '.item_id = all_items.item_id', 'left');
        $this->db->join('users', 'users.user_id = ' . $this->_table . '.user_id', 'left');
        
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
        
        $this->db->select('shop_product_payments.item_id,shop_product_payments.price,shop_product_payments.user_id,all_items.`name`,shop_product_payments.date,shop_product_payments.count,users.login');
        $this->db->join('all_items', '' . $this->_table . '.item_id = all_items.item_id', 'left');
        $this->db->join('users', 'users.user_id = ' . $this->_table . '.user_id', 'left');
        
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
        return $this->db->select('shop_product_payments.item_id,Sum(' . $this->db->dbprefix . 'shop_product_payments.count) as sum,all_items.`name`')
            ->join('all_items', 'shop_product_payments.item_id = all_items.item_id', 'left')
            ->group_by('shop_product_payments.item_id')
            ->get($this->_table)
            ->result_array();
    }
    
    /**
     * Список проданных товаров
     * Формирует данные для графика
     */
    public function get_sales_products_for_graph()
    {
        $data = $this->get_sales_products();
        
        $result = array();
        
        if($data)
        {
            foreach($data as $row)
            {
                $result['name'][]    = $row['name'];
                $result['item_id'][] = $row['item_id'];
                $result['sum'][]     = $row['sum'];
            }
        }
        
        return $result;
    }
}