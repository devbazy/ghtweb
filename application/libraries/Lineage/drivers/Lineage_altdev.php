<?php

class Lineage_altdev extends CI_Driver
{
    public $char_id      = 'obj_Id'; // characters
    public $access_level = 'access_level'; // accounts



    public function insert_account($login, $password)
    {
        $data = array(
            'login'             => $login,
            'password'          => $password,
            $this->access_level => '0',
        );

        if(!$this->db->insert('accounts', $data))
        {
            return false;
        }

        return $this->db->insert_id();
    }

    public function get_account_by_login($login)
    {
        return $this->get_accounts(1, NULL, array('login' => $login));
    }

    public function get_accounts_by_login($login, $limit = NULL, $offset = NULL)
    {
        $where          = NULL;
        $where_in_field = 'login';
        $where_in       = NULL;

        if(is_array($login))
        {
            $where_in = $login;
        }
        else
        {
            $where = array('login' => $login);
        }

        return $this->get_accounts($limit, $offset, $where, NULL, NULL, NULL, NULL, $where_in_field, $where_in);
    }

    public function get_accounts($limit = NULL, $offset = NULL, array $where = NULL, $order_by = NULL, $order_type = 'asc', array $like = NULL, array $group_by = NULL, $where_in_field = NULL, array $where_in = NULL)
    {
        if(is_numeric($limit))
        {
            $this->db->limit($limit);
        }

        if(is_numeric($offset))
        {
            $this->db->offset($offset);
        }

        if($where != NULL)
        {
            $this->db->where($where);
        }

        if($order_by != NULL)
        {
            $this->db->order_by($order_by, $order_type);
        }

        if($like != NULL)
        {
            $this->db->like($like);
        }

        if($group_by != NULL)
        {
            $this->db->group_by($group_by);
        }

        if($where_in_field != NULL && $where_in != NULL)
        {
            $this->db->where_in($where_in_field, $where_in);
        }

        if($limit == 1)
        {
            return $this->db->get('accounts')->row_array();
        }

        $this->db->select('*,last_access as lastactive');

        return $this->db->get('accounts')->result_array();
    }

    public function get_characters($limit = NULL, $offset = NULL, array $where = NULL, $order_by = NULL, $order_type = 'asc', array $like = NULL, array $group_by = NULL, $where_in_field = NULL, array $where_in = NULL)
    {
        if(is_numeric($limit))
        {
            $this->db->limit($limit);
        }

        if(is_numeric($offset))
        {
            $this->db->offset($offset);
        }

        if($where != NULL)
        {
            $this->db->where($where);
        }

        if($order_by != NULL)
        {
            $this->db->order_by($order_by, $order_type);
        }

        if($like != NULL)
        {
            if(isset($like['level']))
            {
                $like['character_subclasses.level'] = $like['level'];
                unset($like['level']);
            }

            $this->db->like($like);
        }

        if($group_by != NULL)
        {
            $this->db->group_by($group_by);
        }

        if($where_in_field != NULL && $where_in != NULL)
        {
            $this->db->where_in($where_in_field, $where_in);
        }

        $this->db->select('characters.account_name,characters.obj_Id,characters.char_name,characters.sex,characters.x,characters.y,characters.z,characters.karma,characters.pvpkills,
            characters.pkkills,characters.clanid,characters.title,characters.accesslevel,characters.`online`,characters.onlinetime,characters.vitality,clan_subpledges.clan_id,
            clan_data.clan_level,clan_data.hasCastle,clan_data.hasFortress,clan_data.ally_id,clan_data.reputation_score,clan_data.crest,char_templates.RaceId AS race,
            character_subclasses.class_id AS classid,character_subclasses.`level`,character_subclasses.exp,character_subclasses.sp,character_subclasses.curHp,character_subclasses.curMp,
            character_subclasses.curCp,character_subclasses.maxHp,character_subclasses.maxMp,character_subclasses.maxCp,clan_subpledges.name as clan_name,clan_subpledges.leader_id
        ');

        $this->db->join('character_subclasses', 'characters.obj_Id = character_subclasses.char_obj_id', 'left');
        $this->db->join('char_templates', 'character_subclasses.class_id = char_templates.ClassId', 'left');
        $this->db->join('clan_data', 'characters.clanid = clan_data.clan_id', 'left');
        $this->db->join('clan_subpledges', 'clan_subpledges.clan_id = clan_data.clan_id', 'left');

        if($limit == 1)
        {
            return $this->db->get('characters')->row_array();
        }

        return $this->db->get('characters')->result_array();
    }

    public function get_characters_by_login($login, $limit = NULL, $offset = NULL)
    {
        $where          = NULL;
        $where_in_field = 'account_name';
        $where_in       = NULL;

        if(is_array($login))
        {
            $where_in = $login;
        }
        else
        {
            $where = array('account_name' => $login);
        }

        return $this->get_characters($limit, $offset, $where, NULL, NULL, NULL, NULL, $where_in_field, $where_in);
    }

    public function change_password_on_account($password, $login)
    {
        return $this->db->update('accounts', array('password' => $password), array('login' => $login), 1);
    }

    public function get_character_by_char_id($char_id)
    {
        return $this->get_characters(1, NULL, array($this->char_id => $char_id));
    }

    public function change_coordinates($data, $char_id)
    {
        return $this->db->update('characters', $data, array($this->char_id => $char_id), 1);
    }

    public function insert_item($item_id, $count, $char_id, $enchant, $loc)
    {
        $this->db->select_max('object_id', 'max_id');
        $max_id = $this->db->get('items', 1)->row_array();

        $data_db = array(
            'owner_id'      => $char_id,
            'object_id'     => $max_id['max_id'] + 1,
            'item_id'       => $item_id,
            'count'         => $count,
            'enchant_level' => (int) $enchant,
            'loc'           => $loc,
            'loc_data'      => '0',
        );

        return $this->db->insert('items', $data_db);
    }

    public function edit_item($object_id, $count, $char_id, $enchant = 0, $loc = 'INVENTORY')
    {
        $data_db_where = array(
            'owner_id'  => $char_id,
            'object_id' => $object_id,
        );

        $data_db = array(
            'count'         => $count,
            'enchant_level' => (int) $enchant,
            'loc'           => $loc,
            'loc_data'      => '0',
        );

        return $this->db->update('items', $data_db, $data_db_where, 1);
    }

    public function del_item($item_id, $limit)
    {
        if(is_array($item_id))
        {
            $this->db->where($item_id);
        }
        else
        {
            $this->db->where('object_id', $item_id);
        }

        $this->db->limit($limit);
        return $this->db->delete('items');
    }

    public function del_items_by_owner_id($owner_id)
    {
        return $this->db->delete('items', array('owner_id' => $owner_id));
    }

    public function get_character_item_by_item_id($char_id, $item_id)
    {
        $data_db_where = array(
            'owner_id' => $char_id,
            'item_id'  => $item_id
        );

        return $this->get_character_items(1, 0, $data_db_where);
    }

    public function get_online_status($char_id)
    {
        $res = $this->get_characters(1, NULL, array($this->char_id => $char_id));

        return $res['online'];
    }

    public function get_count_characters_online_group_race()
    {
        $races = range(0, 5);

        return $this->db->select('COUNT(0) as `count`, `race`')
            ->where_in('race', $races)
            ->where('online', '1')
            ->group_by('race')
            ->get('characters')
            ->result_array();
    }

    public function get_count_online()
    {
        return $this->get_count_row(array('online' => '1'), NULL, 'characters');
    }

    public function get_count_accounts(array $where = NULL, array $like = NULL)
    {
        return $this->get_count_row($where, $like, 'accounts');
    }

    public function get_count_characters(array $where = NULL, array $like = NULL)
    {
        $this->db->join('character_subclasses', 'character_subclasses.char_obj_id = characters.' . $this->char_id, 'left');

        return $this->get_count_row($where, $like, 'characters');
    }

    public function get_count_clans(array $where = NULL, array $like = NULL)
    {
        return $this->get_count_row($where, $like, 'clan_data');
    }

    public function get_count_male()
    {
        return $this->get_count_row(array('sex' => '0'), NULL, 'characters');
    }

    public function get_count_female()
    {
        return $this->get_count_row(array('sex' => '1'), NULL, 'characters');
    }

    public function get_count_race_by_id($race_id)
    {
        return $this->get_count_row(array('race' => $race_id), NULL, 'characters');
    }

    public function get_count_races_group_race()
    {
        $races = range(0, 5);

        $this->db->select('COUNT(0) as `count`,`char_templates`.`RaceId` as `race`,`characters`.`online`');

        $this->db->join('character_subclasses', 'characters.obj_Id = character_subclasses.char_obj_id', 'left');
        $this->db->join('char_templates', 'character_subclasses.class_id = char_templates.ClassId', 'left');

        $this->db->where_in('RaceId', $races);
        $this->db->group_by('RaceId');
        return $this->db->get('characters')
            ->result_array();
    }

    public function get_top_pvp($limit = NULL)
    {
        return $this->get_characters($limit, NULL, array('pvpkills >' => '0'), 'pvpkills', 'desc');
    }

    public function get_top_pk($limit = NULL)
    {
        return $this->get_characters($limit, NULL, array('pkkills >' => '0'), 'pkkills', 'desc');
    }

    public function get_top_clans($limit = NULL)
    {
        return $this->db->select('clan_data.clan_id,clan_data.clan_level,clan_data.hasCastle,clan_data.hasFortress,clan_data.ally_id,clan_data.crest,clan_data.reputation_score,
                characters.pkkills,characters.pvpkills,characters.karma,characters.z,characters.y,characters.x,characters.sex,characters.char_name,characters.account_name,
                characters.title,characters.accesslevel,characters.`online`,characters.onlinetime,characters.lastAccess,character_subclasses.class_id AS classid,character_subclasses.`level`,
                character_subclasses.exp,character_subclasses.sp,character_subclasses.curHp,character_subclasses.curMp,character_subclasses.curCp,character_subclasses.maxHp,COUNT(character_subclasses.`level`) as ccount,
                character_subclasses.maxMp,character_subclasses.maxCp,clan_subpledges.leader_id,clan_subpledges.`name` AS clan_name,char_templates.RaceId AS race,ally_data.ally_name
            ')
            ->join('characters', 'clan_data.clan_id = characters.clanid', 'left')
            ->join('character_subclasses', 'characters.obj_Id = character_subclasses.char_obj_id', 'left')
            ->join('clan_subpledges', 'clan_data.clan_id = clan_subpledges.clan_id', 'left')
            ->join('char_templates', 'character_subclasses.class_id = char_templates.ClassId', 'left')
            ->join('ally_data', 'clan_data.ally_id = ally_data.ally_id', 'left')

            ->group_by('clanid')
            ->order_by('clan_level', 'DESC')
            ->order_by('reputation_score', 'DESC')
            ->limit($limit)
            ->get('clan_data')
            ->result_array();
    }

    public function get_top_online($limit = 10)
    {
        return $this->get_characters($limit, NULL, array('online' => '1'), 'level', 'desc');
    }

    public function get_top($limit = 10)
    {
        return $this->get_characters($limit, NULL,  NULL, 'exp', 'desc');
    }

    public function get_top_rich($limit = 10)
    {
        $this->db->select('characters.account_name,characters.obj_Id,characters.char_name,characters.sex,characters.x,characters.y,characters.z,characters.karma,characters.pvpkills,
            characters.pkkills,characters.clanid,characters.title,characters.accesslevel,characters.`online`,characters.onlinetime,characters.vitality,clan_subpledges.clan_id,
            clan_data.clan_level,clan_data.hasCastle,clan_data.hasFortress,clan_data.ally_id,clan_data.reputation_score,clan_data.crest,char_templates.RaceId AS race,
            character_subclasses.class_id AS classid,character_subclasses.`level`,character_subclasses.exp,character_subclasses.sp,character_subclasses.curHp,character_subclasses.curMp,
            character_subclasses.curCp,character_subclasses.maxHp,character_subclasses.maxMp,character_subclasses.maxCp,clan_subpledges.`name` AS clan_name,clan_subpledges.leader_id,items.count,SUM(items.count) as adena

        ');

        $this->db->join('character_subclasses', 'characters.obj_Id = character_subclasses.char_obj_id', 'left');
        $this->db->join('char_templates', 'character_subclasses.class_id = char_templates.ClassId', 'left');
        $this->db->join('clan_data', 'characters.clanid = clan_data.clan_id', 'left');
        $this->db->join('clan_subpledges', 'clan_subpledges.clan_id = clan_data.clan_id', 'left');
        $this->db->join('items', 'characters.obj_Id = items.owner_id', 'left');

        $this->db->order_by('items.count', 'desc');
        $this->db->group_by('characters.' . $this->char_id);
        $this->db->where('items.item_id', '57');

        return $this->db->get('characters', $limit)
            ->result_array();
    }

    public function get_castles()
    {
        $this->db->select('castle.id,
            castle.`name`,
            castle.tax_percent AS taxPercent,
            castle.treasury,
            castle.last_siege_date,
            castle.own_date,
            castle.siege_date AS siegeDate,
            castle.reward_count,
            clan_subpledges.`name` AS clan_name,
            clan_subpledges.clan_id');

        $this->db->join('clan_data', 'clan_data.hasCastle = castle.id', 'left');
        $this->db->join('clan_subpledges', 'clan_data.clan_id = clan_subpledges.clan_id', 'left');

        $this->db->order_by('castle.id');

        return $this->db->get('castle')
            ->result_array();
    }

    public function get_siege()
    {
        $this->db->select('clan_data.reputation_score,clan_data.crest AS crest_id,clan_data.ally_id,clan_data.hasFortress AS hasFort,clan_data.hasCastle,clan_data.clan_level,clan_data.clan_id,siege_clans.residence_id AS castle_id,IF(siege_clans.type = "attackers",1,2) AS type,LEFT(siege_clans.date, 10) AS date,clan_subpledges.`name` as clan_name', false);

        $this->db->join('clan_data', 'siege_clans.clan_id = clan_data.clan_id', 'left');
        $this->db->join('clan_subpledges', 'siege_clans.clan_id = clan_subpledges.clan_id', 'left');
        $this->db->where_in('residence_id', range(1, 9));

        return $this->db->get('siege_clans')
            ->result_array();
    }

    public function get_clan_by_id($clan_id)
    {
        $this->db->select('clan_data.clan_id,clan_data.clan_level,clan_data.hasCastle,clan_data.hasFortress AS hasFort,clan_subpledges.`name` AS clan_name,clan_data.ally_id,clan_data.reputation_score,clan_subpledges.leader_id');
        $this->db->where('clan_data.clan_id', $clan_id);
        $this->db->join('clan_subpledges', 'clan_data.clan_id = clan_subpledges.clan_id', 'left');

        return $this->db->get('clan_data')
            ->row_array();
    }

    public function get_characters_by_clan_id($clan_id, $limit = 10)
    {
        return $this->get_characters($limit, NULL, array('clanid' => $clan_id), 'level', 'desc');
    }

    public function get_count_character_items($char_id)
    {
        return $this->get_count_row(array('owner_id' => $char_id), NULL, 'items');
    }

    public function get_character_items($limit = NULL, $offset = NULL, array $where = NULL, $order_by = NULL, $order_type = 'asc', array $like = NULL, array $group_by = NULL, $where_in_field = NULL, array $where_in = NULL)
    {
        if(is_numeric($limit))
        {
            $this->db->limit($limit);
        }

        if(is_numeric($offset))
        {
            $this->db->offset($offset);
        }

        if($where != NULL)
        {
            $this->db->where($where);
        }

        if($order_by != NULL)
        {
            $this->db->order_by($order_by, $order_type);
        }

        if($like != NULL)
        {
            $this->db->like($like);
        }

        if($group_by != NULL)
        {
            $this->db->group_by($group_by);
        }

        if($where_in_field != NULL && $where_in != NULL)
        {
            $this->db->where_in($where_in_field, $where_in);
        }

        if($limit == 1)
        {
            return $this->db->get('items')->row_array();
        }

        return $this->db->get('items')->result_array();
    }

    private function get_count_row(array $where = NULL, array $like = NULL, $table)
    {
        if($where != NULL)
        {
            $this->db->where($where);
        }

        if($like != NULL)
        {
            $this->db->like($like);
        }

        $this->db->from($table);
        return $this->db->count_all_results();
    }
}