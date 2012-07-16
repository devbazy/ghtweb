<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Character_info extends Controllers_Cabinet_Base
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('users_on_server_model');

        $this->set_meta_title(lang('Информация о персонаже'));
    }



    public function index()
    {
        if($this->_data['server_list'])
        {
            $server_id = (int) get_segment_uri(3);
            $char_id   = (int) get_segment_uri(4);
            $user_id   = $this->auth->get('user_id');
            
            if(!isset($this->_data['server_list'][$server_id]) || $char_id < 1)
            {
                redirect('cabinet/game_accounts');
            }

            if(!($content = $this->cache->get('cabinet/character_info_' . $server_id . '_' . $char_id . '_' . $user_id)))
            {
                $content = array(
                    'items'          => array(),
                    'character_data' => array(),
                );

                $this->lineage
                    ->set_id($server_id)
                    ->set_type('servers');

                // Данные персонажа
                $character_data = $this->lineage->get_character_by_char_id($char_id);

                if(!$character_data)
                {
                    $this->session->set_flashdata('message', Message::false('Персонаж не найден'));
                    redirect('cabinet/game_accounts');
                }


                // Клан инфо
                if($this->_l2_settings['servers'][$server_id]['stats_clan_info'] && $character_data['clan_name'] != '')
                {
                    $character_data['clan_name'] = anchor('stats/' . $server_id . '/clan_info/' . $character_data['clan_id'], $character_data['clan_name'], 'target="_blank"');
                }
                elseif($character_data['clan_name'] == '')
                {
                    $character_data['clan_name'] = lang('нет');
                }


                // Проверка, принадлежит ли аккаунт данному пользователю
                $check_account = $this->users_on_server_model->get_row(array(
                    'user_id'             => $user_id,
                    'server_id'           => $server_id,
                    'server_account_name' => $character_data['account_name'],
                ));

                if(!$check_account)
                {
                    $this->session->set_flashdata('message', Message::false('Можно просматривать информацию только от своего персонажа'));
                    redirect('cabinet/game_accounts');
                }


                // Предметы
                $items_res = $this->lineage->get_character_items_by_char_id($character_data['char_id']);

                // Забираю ID
                $items_ids = array();

                foreach($items_res as $item)
                {
                    $items_ids[] = $item['item_id'];
                }

                $items_ids = array_unique($items_ids);


                if($items_ids)
                {
                    // Забираю названия предметов
                    $this->db->where_in('item_id', $items_ids);
                    $names_items_res = $this->db->get('all_items')->result_array();

                    $names_items = array();

                    foreach($names_items_res as $row)
                    {
                        $names_items[$row['item_id']] = $row;
                    }

                    unset($items_ids, $names_items_res);


                    // Добавляю имена
                    if($names_items)
                    {
                        foreach($items_res as $row)
                        {
                            $grade = isset($names_items[$row['item_id']]['crystal_type']) ? $names_items[$row['item_id']]['crystal_type'] : '';
                            $grade = ($grade == 'none' ? '' : $grade);

                            $name = (isset($names_items[$row['item_id']]['name']) ? $names_items[$row['item_id']]['name'] : 'n/a');

                            $row['name']        = $name;
                            $row['grade']       = $grade;
                            $content['items'][] = $row;
                        }
                    }

                    unset($items_res);
                }

                $content['character_data'] = $character_data;

                $this->cache->save('cabinet/character_info_' . $server_id . '_' . $char_id . '_' . $user_id, $content, 300);
            }


            $this->_data['items']          = $content['items'];
            $this->_data['character_data'] = $content['character_data'];
        }
        else
        {
            $this->_data['message'] = Message::info('Сервер(а) в данный момент не доступны');
        }

        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
}