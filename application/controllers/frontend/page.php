<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Page extends Controllers_Frontend_Base
{
	public function index()
	{
        $page_name = get_segment_uri(2);
        
        if($page_name == '')
        {
            redirect();
        }
        
        $lang = $this->config->item('language');
        
        
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
        
        $this->_data['content'] = $content;
        
        $this->set_meta_title(lang('Страница не найдена'));
        
        if($content)
        {
            $this->set_meta_title($this->_data['content']['seo_title']);
            $this->set_meta_description($this->_data['content']['seo_description']);
            $this->set_meta_keywords($this->_data['content']['seo_keywords']);
        }
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
}