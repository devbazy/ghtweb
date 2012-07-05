<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Change_Password extends Controllers_Cabinet_Base
{
	public function index()
	{
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            $this->form_validation->set_rules('old_password', 'lang:Старый пароль', 'trim|required|min_length[4]|max_length[20]');
            $this->form_validation->set_rules('new_password', 'lang:Новый пароль', 'trim|required|min_length[4]|max_length[20]');
            
            if($this->form_validation->run())
            {
                $old_password = $this->input->post('old_password', true);
                $new_password = $this->input->post('new_password', true);
                
                
                if($this->auth->check_passwords($old_password, $this->auth->get('password')))
                {
                    $this->auth->set(array(
                        'password' => $this->auth->password_encript($new_password),
                    ), true);
                    
                    $this->_data['message'] = Message::true('Пароль изменён');
                }
                else
                {
                    $this->_data['message'] = Message::false('Текущий пароль и введенный пароль не совпадают');
                }
            }
        }
        
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
}