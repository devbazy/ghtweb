<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Register extends Controllers_Frontend_Base
{
	public function index()
	{
        $this->set_meta_title(lang('Регистрация'));

        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            $this->form_validation->set_rules('login', 'lang:Логин', 'trim|required|xss_clean|min_length[4]|max_length[20]|callback__check_user_login');
            $this->form_validation->set_rules('email', 'lang:Email', 'trim|required|valid_email|callback__check_user_email');
            $this->form_validation->set_rules('password', 'lang:Пароль', 'trim|required|min_length[4]|max_length[20]');
            $this->form_validation->set_rules('repassword', 'lang:Повтор пароля', 'trim|required|matches[password]');
            $this->form_validation->set_rules('captcha', 'lang:Код с картинки', 'trim|required|callback__check_captcha');
            
            
            if($this->form_validation->run())
            {
                $login    = $this->input->post('login', true);
                $password = $this->input->post('password', true);
                $email    = $this->input->post('email', true);
                
                $email_activation = $this->config->item('activated_account_by_email');

                $activated_hash      = NULL;
                $activated_hash_time = NULL;

                if($email_activation)
                {
                    $this->load->helper('string');
                    
                    $activated_hash      = md5(random_string('alnum', 15));
                    $activated_hash_time = db_date();
                }
                
                $this->load->helper('string');
                $referrer_link = random_string('alnum', 15);


                $data_db = array(
                    'login'               => $login,
                    'password'            => $this->auth->password_encript($password),
                    'email'               => $email,
                    'activated'           => ($email_activation ? '0' : '1'),
                    'activated_hash'      => $activated_hash,
                    'activated_hash_time' => $activated_hash_time,
                    'referrer_link'       => $referrer_link,
                    'joined'              => db_date(),
                );


                $insert_id = $this->users_model->add($data_db);

                if($insert_id)
                {
                    $this->_data['message'] = Message::true('Регистрация прошла удачно, приятной игры');
                    
                    if($email_activation)
                    {
                        $activation_link = site_url('register/activation/' . $activated_hash);
                        
                        $this->load->model('email_templates_model');
                        
                        $message = $this->email_templates_model->get_template('register_email_activation');
                        
                        if(!$message)
                        {
                            $message['text'] = 'Письмо не найдено';
                            $message['title'] = 'Письмо не найдено';
                        }
                        
                        $title = $message['title'];
                        
                        $message = strtr($message['text'], array(
                            ':site_url'        => site_url(),
                            ':activation_link' => $activation_link,
                        ));
                        
                        send_mail($email, $title, $message);
                        
                        $this->_data['message'] = Message::true('Регистрация прошла удачно, на Ваш email :email отправлены инструкции по активации аккаунта', array(
                            ':email' => '<b>' . $email . '</b>',
                        ));
                    }
                }
                else
                {
                    log_message('error', 'Не удалось сделать запись нового юзера в БД, при регистрации');
                    $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
                }

            }
        }
        
        $captcha = $this->captcha->get_img();
        $this->_data['captcha'] = $captcha['image'];
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
    
    /**
     * Активация аккаунта
     */
    public function activation()
    {
        $this->set_meta_title(lang('Активация аккаунта'));
        
        $activation_hash = get_segment_uri(3);
        
        $data_db_where = array(
            'activated_hash' => $activation_hash,
            'activated'      => '0',
        );
        
        
        $user_data = $this->users_model->get_row($data_db_where);
        
        if($user_data)
        {
            $time_for_account_activation = (time() - $this->config->item('time_for_account_activation') * 60);
            
            if(strtotime($user_data['activated_hash_time']) > $time_for_account_activation)
            {
                $data_db = array(
                    'activated_hash'      => NULL,
                    'activated_hash_time' => NULL,
                    'activated'           => '1',
                );
                
                if($this->users_model->edit($data_db, $data_db_where, 1))
                {
                    $this->_data['message'] = Message::true('Аккаунт активирован');
                }
                else
                {
                    log_message('error', 'Не удалось активировать аккаунт hash: ' . $activation_hash);
                    $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
                }
            }
            else
            {
                // Timeout
                $this->_data['message'] = Message::false('Ключ для активации аккаунта истёк');
            }
        }
        else
        {
            $this->_data['message'] = Message::false('Ключ активации аккаунта не найден');
        }
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
}