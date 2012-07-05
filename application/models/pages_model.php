<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pages_model extends Crud
{
    public $_table = 'pages';
    
    private $_fields = array(
        'page', 'title', 'text', 'seo_title', 'seo_keywords',
        'seo_description', 'allow', 'lang', 'in_menu');
    
    
    
    public function get_fields()
    {
        return $this->_fields;
    }
    
    /**
     * Возвращает список названий страниц которые будут в меню
     * 
     * @return array
     */
    public function get_pages_in_menu()
    {
        if(!($content = $this->cache->get('page_in_menu')))
        {
            $data_db_where = array(
                'allow'   => '1',
                'lang'    => $this->config->item('language'),
                'in_menu' => '1',
            );
            
            $content = $this->get_list(0, 0, $data_db_where);
            
            $this->cache->save('page_in_menu', $content);
        }
        
        return $content;
    }
    
    public function get_page_titles()
    {
        $res = $this->get_list();
        
        $pages = array();
        
        foreach($res as $row)
        {
            $pages[$row['page']] = $row['title'];
        }
        
        return $pages;
    }
}