<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login extends Controllers_Frontend_Base
{
    public function __construct()
    {
        parent::__construct();
        
        if($this->auth->is_logged())
        {
            redirect('cabinet');
        }

        $this->load->model('login_attempts_model');
    }
    
	public function index()
	{
        $this->set_meta_title(lang('Вход в личный кабинет'));

        $this->load->library('captcha');

        $auth = true;

        $login_attempts_data = $this->login_attempts_model->get_data();

        if(isset($login_attempts_data['count']) && $login_attempts_data['count'] >= $this->config->item('count_failed_login_attempts'))
        {
            $auth = false;
            $this->_data['message'] = Message::info('Для Вас вход в личный кабинет заблокирован за попытку перебора пароля');
        }

        // Праверяю время блокировки
        if($auth === false && (time() > strtotime($login_attempts_data['date']) + (int) $this->config->item('time_blocked_login_attempts') * 60))
        {
            $this->login_attempts_model->clear();
            $auth = true;
            $this->_data['message'] = '';
        }

        if($auth === true && isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            $this->form_validation->set_rules('login', 'lang:Логин', 'trim|required|xss_clean|min_length[4]|max_length[20]');
            $this->form_validation->set_rules('password', 'lang:Пароль', 'trim|required|min_length[4]|max_length[20]');
            $this->form_validation->set_rules('captcha', 'lang:Код с картинки', 'trim|required|callback__check_captcha');
            
            if($this->form_validation->run())
            {
                $login    = $this->input->post('login', true);
                $password = $this->input->post('password', true);
                
                
                $data_db_where = array(
                    'login' => $login
                );
                
                $user_data = $this->users_model->get_row($data_db_where);
                
                if($user_data)
                {
                    if($user_data['activated'] == 0)
                    {
                        $this->_data['message'] = Message::false('Аккаунт не активирован');
                    }
                    elseif($user_data['protected_ip'] != '' && $user_data['protected_ip'] != $this->input->ip_address())
                    {
                        $this->_data['message'] = Message::false('С Вашего IP нельзя войти в личный кабинет');
                    }
                    elseif($user_data['banned'])
                    {
                        $this->_data['message'] = Message::false('Мастер Аккаунт заблокирован, причина: :banned_reason', array(
                            ':banned_reason' => $user_data['banned_reason'],
                        ));
                    }
                    elseif($user_data['password'] == $this->auth->password_encript($password))
                    {
                        $this->auth->auth($user_data['user_id']);
                        redirect('cabinet');
                    }
                    else
                    {
                        $this->_data['message'] = Message::false('Пароль от аккаунта введен неверно');

                        $this->login_attempts_model->add_false_attempt();
                    }
                }
                else
                {
                    $this->_data['message'] = Message::false('Аккаунт не найден');
                }
            }
        }
        
        
        $captcha = $this->captcha->get_img();
        $this->_data['captcha'] = $captcha['image'];
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
}