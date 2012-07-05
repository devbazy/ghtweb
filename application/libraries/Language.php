<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Language
{
    private $_CI;
    
    
    public function __construct()
    {
        $this->_CI =& get_instance();
        
        $language_default = $this->_CI->config->item('language_default');
        $session_lang     = $this->_CI->session->userdata('lang');
        
        // Если AJAX то язык возьмёт из session
        if($this->_CI->input->is_ajax_request())
        {
            $current_lang = $session_lang;
        }
        else
        {
            $current_lang = $this->_CI->uri->segment(1);
        }
        
        
        if($this->_CI->config->item($current_lang, 'languages') && ($language_default != $current_lang))
        {
            $language = $current_lang;
        }
        else
        {
            $language = $this->_CI->config->item('language_default');
        }
        
        $this->_CI->config->set_item('language', $language);
        
        $this->_CI->session->set_userdata('lang', $language);
        
        $this->_CI->lang->load('main', $language);
    }
    
    /**
     * Возвращает текущий язык если он не равен дефолтному
     * 
     * @return string
     */
    public function get_lang()
    {
        $fsu = $this->_CI->uri->segment(1);

        if($this->_CI->config->item($fsu, 'languages') && ($fsu != $this->_CI->config->item('language_default')))
        {
            return $fsu . '/';
        }
        
        return '';
    }
    
    /**
     * Используется для вывода выподающего меню, если сайт будет интернациональный
     */
    private function lang_menu()
    {
        $out = '<ul>';
        
        $languages    = $this->config->item('languages');
        $current_uri  = $this->uri->uri_string();
        $current_lang = $this->config->item('language');
        $default_lang = $this->config->item('language_default');
        
        if(preg_match('#' . $current_lang . '#', $current_uri))
        {
            $current_uri = substr($current_uri, 3);
        }
        
        if($current_uri != '')
        {
            $current_uri .= '/';
        }
        
        foreach($languages as $lang_key => $lang_name)
        {
            $link = $lang_key . '/';
            
            if($lang_key == $default_lang)
            {
                $link = '';
            }
            
            $out .= '<li><a href="/' . $link . $current_uri . '">' . $lang_name . '</a></li>';
        }
        
        $out .= '</ul>';
        
        return $out;
    }
}