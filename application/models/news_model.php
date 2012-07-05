<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class News_model extends Crud
{
    public $_table = 'news';
    
    private $_fields = array(
        'title', 'description', 'text', 'seo_title', 'seo_keywords',
        'seo_description', 'allow', 'author', 'lang');
    
    public function get_fields()
    {
        return $this->_fields;
    }
    
}