<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Возвращает название замка по его ID
 * 
 * @param integer $castle_id
 * 
 * @return string
 */
if(!function_exists('get_castle_name'))
{
    function get_castle_name($castle_id = 0)
    {
        $CI =& get_instance();
        
        $castles = $CI->config->item('castles', 'lineage');
        
        if(isset($castles[$castle_id]))
        {
            return $castles[$castle_id];
        }
        
        return lang('нет');
    }
}

/**
 * Возвращает название форта по его ID
 * 
 * @param integer $fort_id
 * 
 * @return string
 */
if(!function_exists('get_fort_name'))
{
    function get_fort_name($fort_id = 0)
    {
        $CI =& get_instance();
        
        $forts = $CI->config->item('forst');
        
        if(isset($forts[$fort_id]))
        {
            return $forts[$fort_id];
        }
        
        return 'n/a';
    }
}

/**
 * Время проведенное в игре
 * 
 * @return string
 */
if(!function_exists('online_time'))
{
    function online_time($time)
    {
        if ($time / 60 / 60 - 0.5 <= 0)
        {
            $onlinetimeH = 0;
        }
        else
        {
            $onlinetimeH = round(($time / 60 / 60) - 0.5);
        }
        
        $onlinetimeM = round((($time / 60 / 60) - $onlinetimeH) * 60);
        
        return $onlinetimeH . 'h ' . $onlinetimeM . 'm';
    }
}

/**
 * Шифрование пароля для аккаунта
 *
 * @param string $pass
 * @param string $type
 * 
 * @return string
 */
if(!function_exists('pass_encode'))
{
    function pass_encode($pass, $type = 'sha1')
    {
        if ($type == 'wirlpool')
        {
            return base64_encode(hash('whirlpool', $pass, true));
        }
        
        return base64_encode(pack('H*', sha1(utf8_encode($pass))));
    }
}

/**
 * Расчёт координат игроков на online карте
 */
if(!function_exists('get_online_map_position'))
{
    function get_online_map_position($point_x, $point_y)
    {
        $map_x = 1807 / 100;
        $map_y = 2613 / 100;
        
        $x = ($point_x + 130000) / (1807*2);
        $y = ($point_y + 0) / (2613*2);
        
        $x = $map_x * $x;
        $y = $map_y * $y + 1295;
        
        return 'margin:' . $y . 'px 0 0 ' . $x . 'px;';
    }
}

// Список городов для телепорта
if(!function_exists('city_for_teleport'))
{
    function city_for_teleport()
    {
        $CI =& get_instance();
        
        $coordinats = $CI->config->item('list_city', 'lineage');
        
        $result = array();
        
        foreach($coordinats as $id => $val)
        {
            $result[$id] = $val['name'];
        }
        
        return $result;
    }
}

/**
 * Возвращает координаты внутри города
 * 
 * @param integer $city_id
 * 
 * @return array
 */
if(!function_exists('coordinates_for_teleport'))
{
    function coordinates_for_teleport($city_id)
    {
        $CI =& get_instance();
        
        $citys = $CI->config->item('list_city', 'lineage');
        
        return (isset($citys[$city_id]) ? $citys[$city_id] : '');
    }
}


/**
 * Возвращает название класса по его ID
 * 
 * @param integer $class_id
 * 
 * @return string
 */
if(!function_exists('get_class_name_by_id'))
{
    function get_class_name_by_id($class_id = 0)
    {
        $class_id = (int) $class_id;
        
        if($class_id < 0)
        {
            return false;
        }
        
        $CI =& get_instance();
        
        $class_list = $CI->config->item('class_list', 'lineage');
        
        return (isset($class_list[$class_id]) ? $class_list[$class_id] : 'n/a');
    }
}

/**
 * Возвращает название расы по её ID
 * 
 * @param integer $race_id
 * 
 * @return string
 */
if(!function_exists('get_race_name_by_id'))
{
    function get_race_name_by_id($race_id = 0)
    {
        $race_id = (int) $race_id;
        
        if($race_id < 0)
        {
            return false;
        }
        
        $CI =& get_instance();

        $races = $CI->config->item('race_list', 'lineage');

        return (isset($races[$race_id]['name']) ? $races[$race_id]['name'] : '');
    }
}

/**
 * Возвращает отформатированное время последнего визита пользователя в игру
 * 
 * @return string
 */
if(!function_exists('lastactive'))
{
    function lastactive($time)
    {
        return ((int) $time > 0 ? date('Y-m-d H:i:s', substr($time, 0, 10)) : 'n/a');
    }
}

/**
 * Определяет цвет у зоточки
 *
 * @return string
 */
if(!function_exists('definition_enchant_color'))
{
    function definition_enchant_color($enchant_level = 0)
    {
        $color = 'black';

        if($enchant_level == 0)
        {
            $color = 'black';
        }
        elseif($enchant_level < 10)
        {
            $color = '#6AA3FF';
        }
        elseif($enchant_level < 16)
        {
            $color = '#0058EA';
        }
        elseif($enchant_level >= 16)
        {
            $color = 'red';
        }

        return $color;
    }
}