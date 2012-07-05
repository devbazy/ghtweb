<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Top_pvp
{
    private static $_CI;



    public function __construct()
    {
        static::$_CI =& get_instance();
    }

    public static function get()
    {
        if(!static::$_CI->config->item('top_pvp_allow'))
        {
            return lang('Модуль отключён');
        }

        // Cache
        if(!($content = static::$_CI->cache->get('top_pvp')))
        {
            static::$_CI->load->add_package_path(APPPATH . 'modules/top_pvp', true);

            $server_id = static::$_CI->config->item('top_pvp_server_id');
            $limit     = static::$_CI->config->item('top_pvp_per_page');

            $content = static::$_CI->lineage->set_id($server_id)->set_type('servers')->get_top_pvp($limit);

            $data_view = array(
                'content' => $content,
            );

            $content = static::$_CI->load->view('top_pvp', $data_view, true);

            static::$_CI->load->remove_package_path(APPPATH . 'modules/top_pvp', true);

            if((int) static::$_CI->config->item('top_pvp_cache_time'))
            {
                static::$_CI->cache->save('top_pvp', $content, static::$_CI->config->item('top_pvp_cache_time') * 60);
            }
        }

        return $content;
    }
}
