<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Top_pk
{
    private static $_CI;



    public function __construct()
    {
        static::$_CI =& get_instance();
    }

    public static function get()
    {
        if(!static::$_CI->config->item('top_pk_allow'))
        {
            return lang('Модуль отключён');
        }

        // Cache
        if(!($content = static::$_CI->cache->get('top_pk')))
        {
            static::$_CI->load->add_package_path(APPPATH . 'modules/top_pk', true);

            $server_id = static::$_CI->config->item('top_pk_server_id');
            $limit     = static::$_CI->config->item('top_pk_per_page');

            $content = static::$_CI->lineage->set_id($server_id)->set_type('servers')->get_top_pk($limit);

            $data_view = array(
                'content' => $content,
            );

            $content = static::$_CI->load->view('top_pk', $data_view, true);

            static::$_CI->load->remove_package_path(APPPATH . 'modules/top_pk', true);

            if((int) static::$_CI->config->item('top_pk_cache_time'))
            {
                static::$_CI->cache->save('top_pk', $content, static::$_CI->config->item('top_pk_cache_time') * 60);
            }
        }

        return $content;
    }
}
