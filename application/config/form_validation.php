<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




$config = array(
    
    // BACKEND
    
    // Новости
    'backend_news' => array(
        array(
            'field' => 'title',
            'label' => 'Название',
            'rules' => 'required|trim|xss_clean|min_length[3]|max_length[255]'
        ),
        array(
            'field' => 'description',
            'label' => 'Описание',
            'rules' => 'required|trim|min_length[5]'
        ),
        array(
            'field' => 'text',
            'label' => 'Текст',
            'rules' => 'required|trim|min_length[5]'
        ),
        array(
            'field' => 'seo_title',
            'label' => 'SEO титул',
            'rules' => 'trim|xss_clean|max_length[255]'
        ),
        array(
            'field' => 'seo_keywords',
            'label' => 'SEO ключевые слова',
            'rules' => 'trim|xss_clean|max_length[255]'
        ),
        array(
            'field' => 'seo_description',
            'label' => 'SEO описание',
            'rules' => 'trim|xss_clean|max_length[255]'
        ),
        array(
            'field' => 'allow',
            'label' => 'Статус',
            'rules' => 'required|exact_length[1]|numeric'
        ),
        array(
            'field' => 'lang',
            'label' => 'Язык',
            'rules' => 'required|exact_length[2]|callback__check_language'
        ),
    ),
    
    // Страницы
    'backend_pages' => array(
        array(
            'field' => 'page',
            'label' => 'Ссылка на страницу',
            'rules' => 'required|trim|xss_clean|min_length[3]|max_length[30]|regex_match[#^[a-z0-9\-\_]+$#siu]'
        ),
        array(
            'field' => 'title',
            'label' => 'Название',
            'rules' => 'required|trim|xss_clean|min_length[3]|max_length[255]'
        ),
        array(
            'field' => 'text',
            'label' => 'Текст',
            'rules' => 'required|trim|min_length[5]'
        ),
        array(
            'field' => 'seo_title',
            'label' => 'SEO титул',
            'rules' => 'trim|xss_clean|max_length[255]'
        ),
        array(
            'field' => 'seo_keywords',
            'label' => 'SEO ключевые слова',
            'rules' => 'trim|xss_clean|max_length[255]'
        ),
        array(
            'field' => 'seo_description',
            'label' => 'SEO описание',
            'rules' => 'trim|xss_clean|max_length[255]'
        ),
        array(
            'field' => 'allow',
            'label' => 'Статус',
            'rules' => 'required|exact_length[1]|numeric'
        ),
        array(
            'field' => 'lang',
            'label' => 'Язык',
            'rules' => 'required|exact_length[2]|callback__check_language'
        ),
        array(
            'field' => 'in_menu',
            'label' => 'Добавить в меню',
            'rules' => 'required|exact_length[1]|numeric'
        ),
    ),
    
    // Сервера
    'backend_servers' => array(
        array(
            'field' => 'name',
            'label' => 'Название',
            'rules' => 'required|trim|xss_clean|min_length[3]|max_length[54]'
        ),
        array(
            'field' => 'ip',
            'label' => 'IP',
            'rules' => 'required|trim|valid_ip'
        ),
        array(
            'field' => 'port',
            'label' => 'Порт',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'db_host',
            'label' => 'MYSQL хост',
            'rules' => 'required|trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'db_port',
            'label' => 'MYSQL порт',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'db_user',
            'label' => 'MYSQL пользователь',
            'rules' => 'required|trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'db_pass',
            'label' => 'MYSQL пароль',
            'rules' => 'trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'db_name',
            'label' => 'MYSQL название БД',
            'rules' => 'required|trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'telnet_host',
            'label' => 'TELNET хост',
            'rules' => 'trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'telnet_port',
            'label' => 'TELNET порт',
            'rules' => 'trim|integer|max_length[8]'
        ),
        array(
            'field' => 'telnet_pass',
            'label' => 'TELNET пароль',
            'rules' => 'trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'login_id',
            'label' => 'Логин',
            'rules' => 'required|trim|integer|callback__check_login_by_id'
        ),
        array(
            'field' => 'version',
            'label' => 'Версия сервера',
            'rules' => 'required|trim|xss_clean|callback__check_version'
        ),
        array(
            'field' => 'allow',
            'label' => 'Статус',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'fake_online',
            'label' => 'Накрутка онлайна',
            'rules' => 'trim|integer|max_length[8]'
        ),
        array(
            'field' => 'allow_teleport',
            'label' => 'Телепорт в город',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'teleport_time',
            'label' => 'Повтор телепорта',
            'rules' => 'required|trim|integer|max_length[5]'
        ),
        array(
            'field' => 'stats_allow',
            'label' => 'Статистика',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'stats_cache_time',
            'label' => 'Время кэширования',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'stats_count_results',
            'label' => 'Кол-во записей',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'stats_total',
            'label' => 'Общая',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'stats_pvp',
            'label' => 'ПВП',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'stats_pk',
            'label' => 'ПК',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'stats_clans',
            'label' => 'Кланы',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'stats_castles',
            'label' => 'Замки',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'stats_online',
            'label' => 'В игре',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'stats_clan_info',
            'label' => 'Информация о клане',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'stats_top',
            'label' => 'Топ игроки',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'stats_rich',
            'label' => 'Богачи',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'exp',
            'label' => 'exp',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'sp',
            'label' => 'sp',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'adena',
            'label' => 'adena',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'items',
            'label' => 'items',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'spoil',
            'label' => 'spoil',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'q_drop',
            'label' => 'quest drop',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'q_reward',
            'label' => 'quest reward',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'rb',
            'label' => 'rb drop',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'erb',
            'label' => 'epic rb drop',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
    ),
    
    // Логины
    'backend_logins' => array(
        array(
            'field' => 'name',
            'label' => 'Название',
            'rules' => 'required|trim|xss_clean|min_length[3]|max_length[54]'
        ),
        array(
            'field' => 'ip',
            'label' => 'IP',
            'rules' => 'required|trim|valid_ip'
        ),
        array(
            'field' => 'port',
            'label' => 'Порт',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'allow',
            'label' => 'Статус',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'version',
            'label' => 'Версия сервера',
            'rules' => 'required|trim|callback__check_version'
        ),
        array(
            'field' => 'db_host',
            'label' => 'MYSQL хост',
            'rules' => 'required|trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'db_port',
            'label' => 'MYSQL порт',
            'rules' => 'required|trim|integer|max_length[8]'
        ),
        array(
            'field' => 'db_user',
            'label' => 'MYSQL пользователь',
            'rules' => 'required|trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'db_pass',
            'label' => 'MYSQL пароль',
            'rules' => 'trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'db_name',
            'label' => 'MYSQL название БД',
            'rules' => 'required|trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'telnet_host',
            'label' => 'TELNET хост',
            'rules' => 'trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'telnet_port',
            'label' => 'TELNET порт',
            'rules' => 'trim|integer|max_length[8]'
        ),
        array(
            'field' => 'telnet_pass',
            'label' => 'TELNET пароль',
            'rules' => 'trim|xss_clean|max_length[54]'
        ),
        array(
            'field' => 'version',
            'label' => 'Версия сервера',
            'rules' => 'required|trim|xss_clean|callback__check_version'
        ),
        array(
            'field' => 'password_type',
            'label' => 'Тип шифрования пароля',
            'rules' => 'trim|xss_clean|callback__check_password_encode_type'
        ),
    ),
    
    // Добавление категории для товаров в магазине
    'backend_shop_categories' => array(
        array(
            'field' => 'name',
            'label' => 'Название',
            'rules' => 'required|trim|xss_clean|min_length[3]|max_length[255]'
        ),
        array(
            'field' => 'allow',
            'label' => 'Статус',
            'rules' => 'required|trim|integer'
        ),
    ),
    
    // Добавление товара в магазин
    'backend_shop_product' => array(
        array(
            'field' => 'item_id',
            'label' => 'Название предмета',
            'rules' => 'trim|required|integer'
        ),
        array(
            'field' => 'item_name',
            'label' => 'Название предмета',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'price',
            'label' => 'Цена',
            'rules' => 'trim|required|regex_match[~[0-9\.\,]+~siu]|greater_than[0]'
        ),
        array(
            'field' => 'count',
            'label' => 'Кол-во',
            'rules' => 'trim|required|is_natural'
        ),
        array(
            'field' => 'enchant_level',
            'label' => 'Заточка',
            'rules' => 'trim|required|is_natural'
        ),
        array(
            'field' => 'date_start',
            'label' => 'Дата начала продаж',
            'rules' => 'trim|required|regex_match[~([0-9\-]{10})\s([0-9\:]{8})~siu]'
        ),
        array(
            'field' => 'date_stop',
            'label' => 'Дата окончания продаж',
            'rules' => 'trim|required|regex_match[~([0-9\-]{10})\s([0-9\:]{8})~siu]'
        ),
        array(
            'field' => 'description',
            'label' => 'Описание',
            'rules' => 'trim|xss_clean|max_length[5000]'
        ),
        array(
            'field' => 'category_id',
            'label' => 'Категория',
            'rules' => 'required|trim|integer|callback__check_categories'
        ),
        array(
            'field' => 'item_type',
            'label' => 'Тип предмета',
            'rules' => 'required|trim||callback__check_item_type'
        ),
        array(
            'field' => 'allow',
            'label' => 'Статус',
            'rules' => 'required|trim|integer'
        ),
    ),
);