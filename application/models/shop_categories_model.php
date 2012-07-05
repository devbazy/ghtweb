<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Shop_categories_model extends Crud
{
    public $_table = 'shop_categories';
    
    private $_fields = array(
        'name', 'allow');
    
    
    
    public function get_fields()
    {
        return $this->_fields;
    }
}