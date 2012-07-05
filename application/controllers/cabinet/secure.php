<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Secure extends Controllers_Cabinet_Base
{
	public function index()
	{
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            $this->form_validation->set_rules('protected_ip', 'lang:IP адрес', 'trim|valid_ip');
            
            if($this->form_validation->run())
            {
                $protected_ip = $this->input->post('protected_ip', true);
                
                $data_db = array(
                    'protected_ip' => ($protected_ip == '' ? NULL : $protected_ip),
                );
                
                $this->auth->set($data_db, true);
                
                if($protected_ip == '')
                {
                    $this->_data['message'] = Message::true('Привязка по IP отключена');
                }
                else
                {
                    $this->_data['message'] = Message::true('Привязка по IP включена');
                }
            }
        }
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
}