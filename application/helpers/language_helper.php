<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Переводит строку
 * 
 * @param string: Строка
 * @param array: Массив ключ => значение которые будут заменены в строке
 * 
 * @return string
 */
if(!function_exists('lang'))
{
	function lang($string, array $values = NULL)
	{
		$CI       =& get_instance();
		$new_line = $CI->lang->line($string);
        
        if(!$new_line)
        {
            //$new_line = $string;
            $new_line = 'n/a';
        }
        
        return ($values == NULL ? $new_line : strtr($new_line, $values));
	}
}