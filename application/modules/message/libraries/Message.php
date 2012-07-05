<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Message
{
    public static $_translate = true; // Переводить текст?
    
    
    
    public static function true($text, $array = array())
    {
        return self::generate($text, 'true', $array);
    }
    
    public static function false($text, $array = array())
    {
        return self::generate($text, 'false', $array);
    }
    
    public static function info($text, $array = array())
    {
        return self::generate($text, 'info', $array);
    }
    
    public static function alert($text, $array = array())
    {
        return self::generate($text, 'alert', $array);
    }
    
    private static function generate($text, $type, $array)
    {
        $CI =& get_instance();
        
        $CI->load->add_package_path(APPPATH . 'modules/message', true);
        
        if(self::$_translate === true)
        {
            $text = lang($text);
        }
        
        $text = (is_array($array) && count($array) > 0 ? strtr($text, $array) : $text);
        
        $view = $CI->load->view($type, array('text' => $text), true);
        
        $CI->load->remove_package_path(APPPATH . 'modules/message', true);
        
        return $view;
    }
}