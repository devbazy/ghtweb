<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 
class Forum_threads
{
    private static $_CI;
    private static $_db;
    private static $_error;
    private static $_config = array();
    private static $_types = array(
        'ipb'       => 'topics',
        'smf'       => 'messages',
        'phpbb'     => 'topics',
        'vanilla'   => 'gdn_discussion',
        'vBulletin' => 'thread',
    );



    public function __construct()
    {
        static::$_CI =& get_instance();
    }

    public static function get()
    {
        if(!static::$_CI->config->item('forum_threads_allow'))
        {
            return lang('Модуль отключён');
        }

        // Cache
        if(!($content = static::$_CI->cache->get('forum_threads')))
        {
            static::$_CI->load->add_package_path(APPPATH . 'modules/forum_threads', true);

            // Language
            static::$_CI->lang->load('forum_threads');

            // Config
            static::init_config();

            // Helper
            static::$_CI->load->helper('text');


            if(!isset(static::$_types[static::$_config['forum_type']]))
            {
                $content = lang('Тип форума не поддерживается');
            }
            elseif(static::connect_db())
            {
                $method = 'forum_' . static::$_config['forum_type'];
                $content = static::$method();

                foreach($content as $key => $row)
                {
                    $content[$key]['user_link']  = static::get_starter_link($row['starter_id'], $row['starter_name']);
                    $content[$key]['theme_link'] = static::get_forum_link($row['id_topic'], $row['title'], $row['id_forum']);
                    $content[$key]['start_date'] = date(static::$_config['forum_date_format'], $row['start_date']);
                }
            }
            else
            {
                $content = static::get_error();
            }

            $data_view = array(
                'content'               => $content,
                'forum_character_limit' => static::$_config['forum_character_limit'],
            );

            $content = static::$_CI->load->view('forum_threads', $data_view, true);

            static::$_CI->load->remove_package_path(APPPATH . 'modules/forum_threads', true);

            if((int) static::$_CI->config->item('forum_cache_time'))
            {
                static::$_CI->cache->save('forum_threads', $content, static::$_CI->config->item('forum_cache_time') * 60);
            }
        }

        return $content;
    }

    private static function init_config()
    {
        static::$_config = array(
            'forum_per_page'        => (int) static::$_CI->config->item('forum_per_page'),        // Кол-во тем
            'forum_host'            => static::$_CI->config->item('forum_host'),                  // Хост БД
            'forum_user'            => static::$_CI->config->item('forum_user'),                  // Юзер БД
            'forum_pass'            => static::$_CI->config->item('forum_pass'),                  // Пароль от БД
            'forum_database'        => static::$_CI->config->item('forum_database'),              // Название БД
            'forum_type'            => static::$_CI->config->item('forum_type'),                  // Тип форума
            'forum_prefix'          => static::$_CI->config->item('forum_prefix'),                // Префикс таблиц
            'forum_date_format'     => static::$_CI->config->item('forum_date_format'),           // Формат даты
            'forum_link'            => static::$_CI->config->item('forum_link'),                  // Ссылка на форум
            'forum_cache_time'      => (int) static::$_CI->config->item('forum_cache_time'),      // Время кэширования
            'forum_character_limit' => (int) static::$_CI->config->item('forum_character_limit'), // Кол-во символов в названии темы
        );

        static::$_config['forum_per_page'] = (static::$_config['forum_per_page'] > 0 ? static::$_config['forum_per_page'] : 5);
    }

    private static function  connect_db()
    {
        $config = array(
            'hostname' => static::$_config['forum_host'],
            'username' => static::$_config['forum_user'],
            'password' => static::$_config['forum_pass'],
            'database' => static::$_config['forum_database'],
            'dbdriver' => 'mysqli',
            'dbprefix' => static::$_config['forum_prefix'],
            'pconnect' => FALSE,
            'db_debug' => FALSE,
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
        );

        if(!(static::$_db = static::$_CI->load->database($config, true)))
        {
            static::set_error(lang('Не удалось подключиться к БД'));
            return false;
        }

        if(!is_object(static::$_db->conn_id))
        {
            static::set_error(lang('Не удалось подключиться к БД'));
            return false;
        }

        return true;
    }

    private static function get_error()
    {
        return static::$_error;
    }

    private static function set_error($text)
    {
        static::$_error = $text;
    }



    /*
        id_topic
        start_date
        starter_name
        starter_id
        id_forum
        title
    */
    private static function forum_ipb()
    {
        return static::$_db->select('tid AS id_topic,start_date,starter_name,starter_id,forum_id AS id_forum,title')
            ->from('topics')
            ->order_by('start_date', 'DESC')
            ->limit(static::$_config['forum_per_page'])
            ->get()
            ->result_array();
    }

    private static function forum_phpbb()
    {
        return static::$_db->select('topic_id AS id_topic,topic_time AS start_date,topic_first_poster_name AS starter_name,topic_poster AS starter_id,forum_id AS id_forum,topic_title AS title')
            ->from('topics')
            ->order_by('start_date', 'DESC')
            ->limit(static::$_config['forum_per_page'])
            ->get()
            ->result_array();
    }

    private static function forum_smf()
    {
        return static::$_db->select('id_topic,id_board AS id_forum,`subject` AS title,poster_time AS start_date,poster_name AS starter_name,id_member AS starter_id')
            ->from('messages')
            ->order_by('poster_time', 'DESC')
            ->limit(static::$_config['forum_per_page'])
            ->get()
            ->result_array();
    }
    private static function forum_vanilla()
    {
        return static::$_db->select('gdn_discussion.InsertUserID AS starter_id,gdn_discussion.DiscussionID AS id_forum,gdn_discussion.`Name` AS title,UNIX_TIMESTAMP(gdn_discussion.DateInserted) AS start_date,gdn_user.`Name` AS starter_name,gdn_discussion.CategoryID AS id_topic')
            ->from('gdn_discussion')
            ->join('gdn_user', 'gdn_discussion.InsertUserID = gdn_user.UserID', 'left')
            ->order_by('gdn_discussion.DateInserted', 'DESC')
            ->limit(static::$_config['forum_per_page'])
            ->get()
            ->result_array();
    }

    private static function forum_vBulletin()
    {
        return static::$_db->select('forumid as id_topic, dateline AS start_date, postusername AS starter_name, lastposterid AS starter_id, threadid AS id_forum, title')
            ->from('thread')
            ->order_by('start_date', 'DESC')
            ->limit(static::$_config['forum_per_page'])
            ->get()
            ->result_array();
    }

    private static function clear_link($link)
    {
        return 'http://' . trim(str_replace(array('http://', 'www.'), '', $link), '/') . '/';
    }

    private static function get_forum_link($id_topic, $title, $id_forum)
    {
        $link = static::clear_link(static::$_config['forum_link']);

        switch(static::$_config['forum_type'])
        {
            case 'ipb':
                $link .= 'index.php?/topic/' . $id_topic . '-' . $title . '/';
                break;
            case 'smf':
                $link .= 'index.php?topic=' . $id_topic . '.0';
                break;
            case 'phpbb':
                $link .= 'viewtopic.php?f=' . $id_forum . '&t=' . $id_topic;
                break;
            case 'vanilla':
                $link .= 'discussion/' . $id_forum . '/' . $title;
                break;
            case 'vBulletin':
                $link .= 'showthread.php?' . $id_forum . '-' . $title;
                break;
        }

        return $link;
    }

    private static function get_starter_link($user_id, $user_name)
    {
        $link = static::clear_link(static::$_config['forum_link']);

        switch(static::$_config['forum_type'])
        {
            case 'ipb':
                $link .= 'index.php?/user/' . $user_id . '-' . $user_name . '/';
                break;
            case 'smf':
                $link .= 'index.php?action=profile;u=' . $user_id;
                break;
            case 'phpbb':
                $link .= 'memberlist.php?mode=viewprofile&u=' . $user_id;
                break;
            case 'vanilla':
                $link .= 'profile/' . $user_id . '/' . $user_name;
                break;
            case 'vBulletin':
                $link .= 'member.php?' . $user_id . '-' . $user_name;
                break;
        }

        return $link;
    }

}
