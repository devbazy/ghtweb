<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Top_pk
{
    private static $_CI;



    public function __construct()
    {
        self::$_CI =& get_instance();
    }

    public static function get()
    {
        if(!self::$_CI->config->item('top_pk_allow'))
        {
            return lang('Модуль отключён');
        }

        // Cache
        if(!($content = self::$_CI->cache->get('top_pk')))
        {
            self::$_CI->load->add_package_path(APPPATH . 'modules/top_pk', true);

            $server_id = self::$_CI->config->item('top_pk_server_id');
            $limit     = self::$_CI->config->item('top_pk_per_page');

            $content = self::$_CI->lineage->set_id($server_id)->set_type('servers')->get_top_pk($limit);

            $data_view = array(
                'content' => $content,
            );

            $content = self::$_CI->load->view('top_pk', $data_view, true);

            self::$_CI->load->remove_package_path(APPPATH . 'modules/top_pk', true);

            if((int) self::$_CI->config->item('top_pk_cache_time'))
            {
                self::$_CI->cache->save('top_pk', $content, self::$_CI->config->item('top_pk_cache_time') * 60);
            }
        }

        return $content;
    }
}
