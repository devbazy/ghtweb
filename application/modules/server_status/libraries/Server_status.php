<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Server_status
{
    private static $_CI;



    public function __construct()
    {
        static::$_CI =& get_instance();
    }

    public static function get()
    {
        if(!static::$_CI->config->item('server_status_allow'))
        {
            return lang('Модуль отключён');
        }

        // Cache
        if(!($content = static::$_CI->cache->get('server_status')))
        {
            static::$_CI->load->add_package_path(APPPATH . 'modules/server_status', true);

            // Language
            static::$_CI->lang->load('server_status');

            // Helper
            static::$_CI->load->helper('server_status');


            $server_list              = static::$_CI->servers_model->get_servers_name(true);;
            $total_online             = 0;
            $server_id_for_online_txt = (int) static::$_CI->config->item('server_id_for_online_txt');

            if(!isset($server_list[$server_id_for_online_txt]))
            {
                $server_id_for_online_txt = key($server_list);
            }


            foreach($server_list as $server_id => $server_name)
            {
                $servers_config = static::$_CI->_l2_settings['servers'][$server_id];

                $host        = $servers_config['ip'];
                $port        = (int) $servers_config['port'];
                $fake_online = (int) $servers_config['fake_online'];
                $online      = (int) static::$_CI->lineage->set_id($server_id)->set_type('servers')->get_count_online();

                // Fake online
                if($fake_online > 0)
                {
                    $online = intval($online * (1 + $fake_online / 100));
                }

                $total_online += $online;

                // Online.txt
                if($server_id_for_online_txt == $server_id)
                {
                    if(is_file(FCPATH . 'online.txt'))
                    {
                        file_put_contents(FCPATH . 'online.txt', $online);
                    }
                    else
                    {
                        log_message('error', 'Файл online.txt не найден');
                    }
                }

                $content[$server_id]['status'] = server_status($host, $port);
                $content[$server_id]['online'] = $online;
                $content[$server_id]['name']   = $server_name;
            }
            
            $data_view = array(
                'content'      => $content,
                'total_online' => $total_online,
            );

            $content = static::$_CI->load->view('server_status', $data_view, true);

            static::$_CI->load->remove_package_path(APPPATH . 'modules/server_status', true);

            if((int) static::$_CI->config->item('cache_server_status'))
            {
                static::$_CI->cache->save('server_status', $content, static::$_CI->config->item('cache_server_status') * 60);
            }
        }
        
        return $content;
    }
}
