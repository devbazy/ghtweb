<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class User_groups_model extends Crud
{
    public $_table = 'user_groups';
    
    
    /**
     * Возвращает список групп
     * 
     * @return array
     */
    public function get_groups_list()
    {
        if(!($content = $this->cache->get('user_groups')))
        {
            $res = $this->get_list();

            $content = array();

            foreach($res as $row)
            {
                $content[$row['id']] = $row;
            }
            
            $this->cache->save('user_groups', $content);
        }
        
        return $content;
    }
    
    /**
     * Возвращает список названий групп
     * 
     * @return array
     */
    public function get_groups_names()
    {
        $groups = $this->get_groups_list();
        
        $result = array();
        
        foreach($groups as $group)
        {
            $result[$group['id']] = $group['group_name'];
        }
        
        return $result;
    }
}