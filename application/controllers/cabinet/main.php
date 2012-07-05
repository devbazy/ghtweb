<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Main extends Controllers_Cabinet_Base
{
	public function index()
	{
        $this->load->model('users_on_server_model');

        $data_db_where = array(
            'user_id' => $this->auth->get('user_id'),
        );
        
        $this->_data['count_game_accounts'] = $this->users_on_server_model->get_count($data_db_where);
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
}