<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Статус сервера
 *
 * @param string $host
 * @param integer $port
 * @param integer $timeout
 *
 * @return string
 */
if(!function_exists('server_status'))
{
    function server_status($host = '', $port = '', $timeout = 1)
    {
        if($host == '' || $port == '')
        {
            return 'offline';
        }

        $online = 'offline';

        $sock = @fsockopen($host, $port, $errno, $errstr, $timeout);

        if($sock)
        {
            @fclose($sock);
            $online = 'online';
        }

        return $online;
    }
}