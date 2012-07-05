<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Stats extends Controllers_Frontend_Base
{
    private $_server_id            = 0;         // ID сервера с которым работаем
    private $_servers_config       = array();   // Конфиг текущего сервера
    private $_types_stats          = array();   // Типы разрешенной статистики
    private $_types_stats_for_view = array();   // Типы разрешенной статистики, выводится в view
    private $_current_mod          = array();   // Тукущая статистика которую надо сформировать
    
    
    
    
    public function __construct()
    {
        parent::__construct();

        $this->_data['server_list'] = $this->servers_model->get_servers_name(true);

        if($this->_data['server_list'])
        {
            $this->_server_id = (int) get_segment_uri(2);

            if(!isset($this->_data['server_list'][$this->_server_id]))
            {
                $this->_server_id = key($this->_data['server_list']);
            }

            $this->_servers_config = $this->_l2_settings['servers'][$this->_server_id];

            $this->_data['default_stats'] = '';

            // Проверка включена ли статистика на сервере
            if((boolean) $this->_servers_config['stats_allow'] === false)
            {
                $this->_data['content'] = Message::info('Статистика отключена');
            }
            else
            {
                $this->get_types_stats();

                $mod = (string) get_segment_uri(3);

                // Проверяю сыществует ли мод со статистикой
                if(!isset($this->_types_stats[$mod]))
                {
                    foreach($this->_types_stats as $key => $val)
                    {
                        if($val)
                        {
                            $mod = $key;
                            break;
                        }
                    }
                }

                $this->_current_mod = $mod;
                $this->_data['default_stats'] = $mod;
            }
        }
        else
        {
            $this->_data['message'] = Message::info('Сервер(а) в данный момент не доступны');
        }
    }

    /**
     * Типы статистики
     */
    private function get_types_stats()
    {
        $stats = array();

        foreach($this->_servers_config as $key => $row)
        {
            if((strpos($key, 'stats_') !== false) && ($key != 'stats_allow') && ($key != 'stats_count_results') && ($key != 'stats_cache_time'))
            {
                $stats[str_replace('stats_', '', $key)] = $row;
            }
        }

        $this->_types_stats = $stats;

        // Удаляю ненужные элементы
        if(isset($stats['clan_info']))
        {
            unset($stats['clan_info']);
        }

        $this->_types_stats_for_view = $stats;
    }
    
	public function index()
	{
        $this->set_meta_title(lang('Статистика'));
        
        $this->_data['types_stats'] = $this->_types_stats_for_view;
        $this->_data['server_id']   = $this->_server_id;

        // Проверяю включён ли мод
        if(!$this->_types_stats || !isset($this->_types_stats[$this->_current_mod]))
        {
            $this->_data['content'] = Message::info('Статистика отключена');
        }
        else
        {
            $method = 'stats_' . $this->_current_mod;

            if(method_exists($this, $method))
            {
                $this->_data['content'] = $this->{$method}();
            }
            else
            {
                $this->_data['content'] = Message::false('Метод для обработки статистики не найден');
            }
        }
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
    
    /**
     * Общая статистика
     * 
     * @return string
     */
    private function stats_total()
    {
        if(!($data = $this->cache->get('stats/total_' . $this->_server_id)))
        {
            $data['server_name'] = $this->_servers_config['name'];
            

            $this->lineage
                ->set_id($this->_server_id)
                ->set_type('servers');


            // Кол-во персонажей разных рас которые находятся в игре
            $race_list_res = $this->lineage->get_count_races_group_race();
            $race_list     = array();

            foreach($race_list_res as $row)
            {
                if($row['online'])
                {
                    $race_list[] = array(
                        'count' => $row['count'],
                        'race'  => $row['race'],
                    );
                }
            }

            $data['race_list'] = $race_list;

            unset($race_list_res, $race_list);

            // Рейты
            $data['rates'] = array(
                'exp'      => (int) $this->_servers_config['exp'],
                'sp'       => (int) $this->_servers_config['sp'],
                'adena'    => (int) $this->_servers_config['adena'],
                'items'    => (int) $this->_servers_config['items'],
                'spoil'    => (int) $this->_servers_config['spoil'],
                'q_drop'   => (int) $this->_servers_config['q_drop'],
                'q_reward' => (int) $this->_servers_config['q_reward'],
                'rb'       => (int) $this->_servers_config['rb'],
                'erb'      => (int) $this->_servers_config['erb'],
            );
            
            
            // Статистика (Логин сервер, Игровой сервер, Игроки онлайн, Аккаунтов, Персонажей, Кланов)
            //$logins_config = $this->config->item($this->_servers_config['login_id'], 'logins');

            $data['stats'] = array(
                //'login'      => servers_status($logins_config['ip'], $logins_config['port']),
                //'server'     => servers_status($this->_servers_config['ip'], $this->_servers_config['port']),
                'online'     => (int) $this->lineage->get_count_online(),
                'accounts'   => (int) $this->lineage->set_id($this->_servers_config['login_id'])->set_type('logins')->get_count_accounts(),
                'characters' => (int) $this->lineage->set_id($this->_server_id)->set_type('servers')->get_count_characters(),
                'clans'      => (int) $this->lineage->get_count_clans(),
                'men'        => (int) $this->lineage->get_count_male(),
                'women'      => (int) $this->lineage->get_count_female(),
            );

            // Fake online
            if((int) $this->_servers_config['fake_online'] > 0)
            {
                $data['stats']['online'] += ceil($data['stats']['online'] * $this->_servers_config['fake_online'] / 100);
            }

            // Расы на сервере
            $races_res = $this->lineage->get_count_races_group_race();
            $races     = array();

            foreach($races_res as $race_info)
            {
                $races[$race_info['race']] = $race_info['count'];
            }

            for($i = 0; $i < 6; $i++)
            {
                if(!isset($races[$i]))
                {
                    $races[$i] = 0;
                }
            }

            $human    = (int) $races[0];
            $elf      = (int) $races[1];
            $dark_elf = (int) $races[2];
            $orc      = (int) $races[3];
            $dwarf    = (int) $races[4];
            $kamael   = (int) $races[5];

            unset($races_res, $races);

            $data['race'] = array(
                'percent' => array(
                    'human'    => ($human > 0 ? round($human / $data['stats']['characters'] * 100) : 0),
                    'elf'      => ($elf > 0 ? round($elf / $data['stats']['characters'] * 100) : 0),
                    'dark_elf' => ($dark_elf > 0 ? round($dark_elf / $data['stats']['characters'] * 100) : 0),
                    'orc'      => ($orc > 0 ? round($orc / $data['stats']['characters'] * 100) : 0),
                    'dwarf'    => ($dwarf > 0 ? round($dwarf / $data['stats']['characters'] * 100) : 0),
                    'kamael'   => ($kamael > 0 ? round($kamael / $data['stats']['characters'] * 100) : 0),
                ),
                'count' => array(
                    'human'    => $human,
                    'elf'      => $elf,
                    'dark_elf' => $dark_elf,
                    'orc'      => $orc,
                    'dwarf'    => $dwarf,
                    'kamael'   => $kamael,
                ),
            );
            
            $data = $this->load->view('stats/stats_total', $data, true);
            
            if((int) $this->_servers_config['stats_cache_time'] > 0)
            {
                $this->cache->save('stats/total_' . $this->_server_id, $data, $this->_servers_config['stats_cache_time'] * 60);
            }
        }
        
        return $data;
    }
    
    /**
     * Статистика ПВП
     * 
     * @return string 
     */
    private function stats_pvp()
    {
        if(!($data = $this->cache->get('stats/pvp_' . $this->_server_id)))
        {
            $data['server_name'] = $this->_servers_config['name'];
            $data['clan_info']   = $this->_servers_config['stats_clan_info'];
            $data['server_id']   = $this->_server_id;
            $data['char_id']     = $this->lineage->set_id($this->_server_id)->set_type('servers')->get_char_id();


            $data['content'] = $this->lineage
                ->set_id($this->_server_id)
                ->set_type('servers')
                ->get_top_pvp((int) $this->_servers_config['stats_count_results']);

            $data = $this->load->view('stats/stats_pvp', $data, true);
            
            if((int) $this->_servers_config['stats_cache_time'] > 0)
            {
                $this->cache->save('stats/pvp_' . $this->_server_id, $data, $this->_servers_config['stats_cache_time'] * 60);
            }
        }
        
        return $data;
    }
    
    /**
     * Статистика ПК
     * 
     * @return string 
     */
    private function stats_pk()
    {
        if(!($data = $this->cache->get('stats/pk_' . $this->_server_id)))
        {
            $data['server_name'] = $this->_servers_config['name'];
            $data['clan_info']   = $this->_servers_config['stats_clan_info'];
            $data['server_id']   = $this->_server_id;
            $data['char_id']     = $this->lineage->set_id($this->_server_id)->set_type('servers')->get_char_id();


            $data['content'] = $this->lineage
                ->set_id($this->_server_id)
                ->set_type('servers')
                ->get_top_pk((int) $this->_servers_config['stats_count_results']);

            $data = $this->load->view('stats/stats_pk', $data, true);
            
            if((int) $this->_servers_config['stats_cache_time'] > 0)
            {
                $this->cache->save('stats/pk_' . $this->_server_id, $data, $this->_servers_config['stats_cache_time'] * 60);
            }
        }
        
        return $data;
    }
    
    /**
     * Статистика кланов
     * 
     * @return string 
     */
    private function stats_clans()
    {
        if(!($data = $this->cache->get('stats/clans_' . $this->_server_id)))
        {
            $data['server_name']     = $this->_servers_config['name'];
            $data['server_id']       = $this->_server_id;
            $data['stats_clan_info'] = $this->_servers_config['stats_clan_info'];
            
            
            $data['content'] = $this->lineage
                ->set_id($this->_server_id)
                ->set_type('servers')
                ->get_top_clans((int) $this->_servers_config['stats_count_results']);
            
            $data = $this->load->view('stats/stats_clans', $data, true);
            
            if((int) $this->_servers_config['stats_cache_time'] > 0)
            {
                $this->cache->save('stats/clans_' . $this->_server_id, $data, $this->_servers_config['stats_cache_time'] * 60);
            }
        }
        
        return $data;
    }
    
    /**
     * Статистика замков
     * 
     * @return string 
     */
    private function stats_castles()
    {
        if(!($data = $this->cache->get('stats/castles_' . $this->_server_id)))
        {
            $data['server_name']     = $this->_servers_config['name'];
            $data['server_id']       = $this->_server_id;
            $data['stats_clan_info'] = $this->_servers_config['stats_clan_info'];


            $this->lineage
                ->set_id($this->_server_id)
                ->set_type('servers');

            // Замки
            $castles = $this->lineage->get_castles();

            $content = array();
            
            foreach($castles as $row)
            {
                $content[$row['id']] = array(
                    'name'        => $row['name'],
                    'castle_id'   => $row['id'],
                    'tax_percent' => $row['taxPercent'],
                    'sieg_date'   => $row['siegeDate'],
                    'owner'       => $row['clan_name'],
                    'owner_id'    => $row['clan_id'],
                    'forwards'    => array(),
                    'defenders'   => array(),
                );
            }
            
            unset($castles);
            
            // Атакующие/Защищающиеся
            $fd = $this->lineage->get_siege();
            
            if($fd)
            {
                foreach($fd as $row)
                {
                    if(isset($content[$row['castle_id']]))
                    {
                        if($row['type'] == 1)
                        {
                            $content[$row['castle_id']]['forwards'][] = $row;
                        }
                        elseif($row['type'] == 2)
                        {
                            $content[$row['castle_id']]['defenders'][] = $row;
                        }
                    }
                }
            }
            
            unset($fd);
            
            $data['content'] = $content;
            
            $data = $this->load->view('stats/stats_castles', $data, true);
            
            if((int) $this->_servers_config['stats_cache_time'] > 0)
            {
                $this->cache->save('stats/castles_' . $this->_server_id, $data, $this->_servers_config['stats_cache_time'] * 60);
            }
        }
        
        return $data;
    }
    
    /**
     * Статистика ONLINE
     * 
     * @return string 
     */
    private function stats_online()
    {
        if(!($data = $this->cache->get('stats/online_' . $this->_server_id)))
        {
            $data['server_name'] = $this->_servers_config['name'];
            $data['clan_info']   = $this->_servers_config['stats_clan_info'];
            $data['server_id']   = $this->_server_id;
            
            
            $data['content'] = $this->lineage
                ->set_id($this->_server_id)
                ->set_type('servers')
                ->get_top_online((int) $this->_servers_config['stats_count_results']);
            
            $data = $this->load->view('stats/stats_online', $data, true);

            if((int) $this->_servers_config['stats_cache_time'] > 0)
            {
                $this->cache->save('stats/online_' . $this->_server_id, $data, $this->_servers_config['stats_cache_time'] * 60);
            }
        }

        return $data;
    }
    
    /**
     * Статистика TOP
     * 
     * @return string 
     */
    private function stats_top()
    {
        if(!($data = $this->cache->get('stats/top_' . $this->_server_id)))
        {
            $data['server_name'] = $this->_servers_config['name'];
            $data['clan_info']   = $this->_servers_config['stats_clan_info'];
            $data['server_id']   = $this->_server_id;
            
            
            $data['content'] = $this->lineage
                ->set_id($this->_server_id)
                ->set_type('servers')
                ->get_top((int) $this->_servers_config['stats_count_results']);

            $data = $this->load->view('stats/stats_top', $data, true);
            
            if((int) $this->_servers_config['stats_cache_time'] > 0)
            {
                $this->cache->save('stats/top_' . $this->_server_id, $data, $this->_servers_config['stats_cache_time'] * 60);
            }
        }
        
        return $data;
    }
    
    
    /**
     * Статистика RICH
     * 
     * @return string 
     */
    private function stats_rich()
    {
        if(!($data = $this->cache->get('stats/rich_' . $this->_server_id)))
        {
            $data['server_name'] = $this->_servers_config['name'];
            $data['clan_info']   = $this->_servers_config['stats_clan_info'];
            $data['server_id']   = $this->_server_id;
            
            
            $data['content'] = $this->lineage
                ->set_id($this->_server_id)
                ->set_type('servers')
                ->get_top_rich((int) $this->_servers_config['stats_count_results']);
            
            $data = $this->load->view('stats/stats_rich', $data, true);
            
            if((int) $this->_servers_config['stats_cache_time'] > 0)
            {
                $this->cache->save('stats/rich_' . $this->_server_id, $data, $this->_servers_config['stats_cache_time'] * 60);
            }
        }
        
        return $data;
    }
    
    /**
     * Статистика просмотра информации о клане
     */
    private function stats_clan_info()
    {
        $data['clan_info'] = $this->_servers_config['stats_clan_info'];
        $clan_id           = (int) get_segment_uri(4);

        // Если статистика отключена то перекидываю юзера
        if(!$data['clan_info'] || $clan_id < 1)
        {
            redirect('stats/' . $this->_server_id);
        }
        
        if(!($data = $this->cache->get('stats/clan_info_' . $clan_id . '_' . $this->_server_id)))
        {
            $data['server_name'] = $this->_servers_config['name'];
            $data['server_id']   = $this->_server_id;

            $this->lineage
                ->set_id($this->_server_id)
                ->set_type('servers');


            $data['clan_name'] = '';

            // Данные клана
            $clan_data = $this->lineage
                ->get_clan_by_id($clan_id);

            if($clan_data)
            {
                $data['clan_name'] = $clan_data['clan_name'];

                $data['content'] = $this->lineage
                    ->get_characters_by_clan_id($clan_id, (int) $this->_servers_config['stats_count_results']);

                $data = $this->load->view('stats/stats_clan_info', $data, true);
            }
            else
            {
                $data = array();
            }

            if((int) $this->_servers_config['stats_cache_time'] > 0)
            {
                $this->cache->save('stats/clan_info_' . $clan_id . '_' . $this->_server_id, $data, $this->_servers_config['stats_cache_time'] * 60);
            }
        }
        
        return $data;
    }
}