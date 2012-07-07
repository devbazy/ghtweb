<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Main extends Controllers_Cabinet_Base
{
	public function index()
	{
        $user_id = $this->auth->get('user_id');

        if(!($data = $this->cache->get('cabinet/main_' . $user_id)))
        {
            $this->load->model('users_on_server_model');

            $data = $this->users_on_server_model->get_count_accounts($user_id);

            $this->cache->save('cabinet/main_' . $user_id, $data, 300);
        }

        $this->_data['count_game_accounts'] = $data;
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
}