<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Email_templates_model extends Crud
{
    public $_table = 'email_templates';
    
    
    /**
     * Возвращает шаблон письма
     * 
     * @param string $template_name 
     * 
     * @return string
     */
    public function get_template($template_name)
    {
        if(!($content = $this->cache->get('email_templates/' . $template_name)))
        {
            $data_db = array(
                'tpl_name' => $template_name,
                'lang'     => $this->config->item('language'),
            );
            
            $content = $this->get_row($data_db);
            
            if($content)
            {
                $this->cache->save('email_templates/' . $template_name, $content);
            }
        }
        
        return $content;
    }
}