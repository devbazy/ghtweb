<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Main extends Controllers_Frontend_Base
{
	public function index()
	{
        if($this->config->item('home_page_type') == 'page' && $this->config->item('home_page_name') != '')
        {
            $this->get_page();
        }
        else
        {
            $this->get_news();
        }
	}
    
    /**
     * Формирует главную страницу на основе статической страницы
     */
    private function get_page()
    {
        $lang      = $this->config->item('language');
        $page_name = $this->config->item('home_page_name');
        
        if(!($content = $this->cache->get('pages/' . $page_name . '_' . $lang)))
        {
            $this->load->model('pages_model');

            $data_db_where = array(
                'page'  => $page_name,
                'allow' => '1',
                'lang'  => $lang,
            );
            
            $content = $this->pages_model->get_row($data_db_where);
            
            if($content)
            {
                $this->cache->save('pages/' . $page_name . '_' . $lang, $content);
            }
        }

        $this->set_meta_title(lang('Страница не найдена'));
        
        if($content)
        {
            $this->set_meta_title($content['seo_title']);
            $this->set_meta_description($content['seo_description']);
            $this->set_meta_keywords($content['seo_keywords']);
        }
        
        $this->_data['content'] = $content;
        
		$this->tpl('page/index');
    }
    
    /**
     * Формирует главную страницу на основе новостей
     */
    private function get_news()
    {
        $this->load->model('news_model');
        
        $per_page = (int) $this->config->item('news_per_page');
        $page     = (int) get_segment_uri(1);
        
        $data_db_where = array(
            'allow' => '1',
            'lang'  => $this->config->item('language'),
        );
        
        $this->load->library('pagination');
        
        $this->pagination->initialize(array(
            'base_url'          => '/' . $this->language->get_lang(),
            'total_rows'        => $this->news_model->get_count($data_db_where),
            'per_page'          => $per_page,
            'page_query_string' => false,
            'uri_segment'       => uri_segment(),
        ));
        
        
        $this->_data['pagination'] = $this->pagination->create_links();
        $this->_data['content']    = $this->news_model->get_list($page, $per_page, $data_db_where, 'date', 'DESC');
        
        $this->set_meta_title(lang('Новости'));
        
		$this->tpl('news/index');
    }
}