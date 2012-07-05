<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class GW_Config extends CI_Config
{
	public function set_item($item, $value = '')
	{
        if(is_array($item))
        {
            $this->config = array_merge($this->config, $item);
        }
        else
        {
            $this->config[$item] = $value;
        }
	}
}