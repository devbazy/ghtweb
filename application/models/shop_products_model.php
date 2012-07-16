<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Shop_products_model extends Crud
{
    public $_table = 'shop_products';
    
    private $_fields = array('item_id', 'price', 'count', 'date_start', 'date_stop', 'description', 'category_id', 'allow', 'item_type', 'enchant_level', 'item_type', 'deleted');
    
    
    
    public function get_fields()
    {
        return $this->_fields;
    }
    
    /**
     * Возвращает список товаров отсортированных по категориям
     * 
     * @param mixed $item_id (ID одного товара или массив)
     * @param boolean $with_date (Учитывать даты старта и конца при выборке)
     * 
     * @return array
     */
    public function get_all_products($item_id = 0, $with_date = true)
    {
        if(!is_array($item_id) && (int) $item_id > 0)
        {
            $this->db->where('shop_products.id', $item_id);
        }
        elseif(is_array($item_id))
        {
            $this->db->where_in('shop_products.id', $item_id);
        }
        
        if($with_date)
        {
            $this->db->where('date_start <', db_date());
            $this->db->where('date_stop >', db_date());
        }
        
        $res = $this->db->select('all_items.`name`,shop_products.id,shop_products.item_id,shop_products.price,shop_products.count,shop_products.item_type,shop_products.date_start,shop_products.date_stop,shop_products.description,shop_categories.`name` AS categories_name,shop_products.enchant_level,all_items.crystal_type as grade')
            ->where('shop_products.allow', '1')
            ->where('shop_products.deleted', '0')
            ->where('shop_categories.allow', '1')
            ->order_by('shop_products.created', 'DESC')
            ->join('shop_categories', 'shop_products.category_id = shop_categories.id', 'LEFT')
            ->join('all_items', 'shop_products.item_id = all_items.item_id', 'LEFT')
            ->get($this->_table)
            ->result_array();
        
        $products = array();
        
        foreach($res as $row)
        {
            $products[$row['categories_name']][] = $row;
        }
        
        return $products;
    }
    
    /**
     * Возвращает список товаров и их названий
     * 
     * @param integer $limit
     * @param integer $offset
     * @param array $where
     * @param string $order_by
     * @param string $order_type
     * @param array $like
     *
     * @return array
     */
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
        
        $this->db->select('shop_products.id,shop_products.item_id,shop_products.price,shop_products.count,shop_products.description,shop_products.created,shop_products.allow,(SELECT COUNT(id) FROM `' . $this->db->dbprefix . 'shop_product_payments` WHERE `' . $this->db->dbprefix . 'shop_product_payments`.`item_id` = ' . $this->db->dbprefix . 'shop_products.item_id) AS count_sold,shop_products.date_start,shop_products.date_stop,all_items.`name`,shop_products.enchant_level');
        
        $this->db->join('all_items', 'shop_products.item_id = all_items.item_id', 'left');
        
        return $this->db->get($this->_table)
            ->result_array();
    }
    
    public function get_product($where)
    {
        return $this->db->where($where)
            ->join('all_items', 'shop_products.item_id = all_items.item_id', 'left')
            ->get($this->_table)
            ->row_array();
    }
}