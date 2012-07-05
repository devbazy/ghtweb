<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Crud extends CI_Model
{
    /**
     * @var string: Название таблицы с которой работаем
     */
    public $_table       = '';
    
    /**
     * @var string: Уникальный ключ (не используется)
     */
    public $_primary_key = 'id';
    
    
    
    /**
     * Добавление
     *
     * @param array $data
     * 
     * @return integer
     */
    public function add(array $data = NULL)
    {
		$this->db->insert ($this->_table, $data);
		return $this->db->insert_id();
    }
    
    /**
     * Удаление
     *
     * @param array $where
     * @param integer $limit
     * 
     * @return boolean
     */
    public function del(array $where = NULL, $limit = 1)
	{
        if($limit > 0)
        {
            $this->db->limit($limit);
        }
        
        // Where
        if($where != NULL)
        {
            $this->db->where($where);
        }
        
        return $this->db->delete($this->_table);
    }
    
    /**
     * Редактирование
     *
     * @param array $data
     * @param array $where
     * @param integer $limit
     * 
     * @return boolean
     */
    public function edit(array $data = NULL, array $where = NULL, $limit = 1)
	{
        if($data == NULL)
        {
            return false;
        }
        
        // Where
        if($where != NULL)
        {
            $this->db->where($where);
        }
        
        $this->db->limit($limit);

		return $this->db->update($this->_table, $data);
    }
	
    /**
     * Выборка одиночная
     *
     * @param array $where
     * 
     * @return array
     */
    public function get_row(array $where = NULL)
	{
        if($where != NULL)
        {
            $this->db->where($where);
        }
        
        return $this->db->get($this->_table, 1)
            ->row_array();
    }
    
    /**
     * Выборка по параметрам
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
        
        return $this->db->get($this->_table)
            ->result_array();
    }
	
    /**
     * Выбрать кол-во полей
     *
     * @param array $where
     * @param array $like
     * 
     * @return integer
     */
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
        
        return $this->db->count_all_results($this->_table);
    }
    
    /**
     * Возвращает названия полей таблицы
     * 
     * @return array
     */
    public function get_field_data()
    {
        return $this->db->field_data($this->_table);
    }
}