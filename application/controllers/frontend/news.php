<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class News extends Controllers_Frontend_Base
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('news_model');
    }
    
    
	public function index()
	{
        $this->load->model('news_model');
        
        $per_page = (int) $this->config->item('news_per_page');
        $page     = (int) get_segment_uri(2);
        
        $data_db_where = array(
            'allow' => '1',
            'lang'  => $this->config->item('language'),
        );
        
        $this->load->library('pagination');
        
        $this->pagination->initialize(array(
            'base_url'          => '/' . $this->language->get_lang() . 'news',
            'total_rows'        => $this->news_model->get_count($data_db_where),
            'per_page'          => $per_page,
            'page_query_string' => false,
            'uri_segment'       => uri_segment(2),
        )); 
        
        
        $this->_data['pagination'] = $this->pagination->create_links();
        $this->_data['content']    = $this->news_model->get_list($page, $per_page, $data_db_where, 'date', 'DESC');
        
        $this->set_meta_title(lang('Новости'));
        $this->set_meta_description(lang('Новости'));
        $this->set_meta_keywords(lang('Новости'));
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
    
    public function detail()
    {
        $id = (int) get_segment_uri(3);
        
        if($id < 0)
        {
            redirect('news');
        }
        
        if(!($content = $this->cache->get('news/' . $id)))
        {
            $data_db_where = array(
                'id'    => $id,
                'allow' => '1',
                'lang'  => $this->config->item('language'),
            );
            
            $content = $this->news_model->get_row($data_db_where);
            
            if($content)
            {
                $this->cache->save('news/' . $id, $content);
            }
        }
        
        $this->set_meta_title(lang('Новости'));
        
        if($content)
        {
            $this->set_meta_title($content['seo_title']);
            $this->set_meta_description($content['seo_description']);
            $this->set_meta_keywords($content['seo_keywords']);
        }
        
        $this->_data['content'] = $content;
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
}