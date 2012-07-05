<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Forgotten_Password extends Controllers_Frontend_Base
{
    public function index()
	{
        $this->set_meta_title(lang('Восстановление пароля'));
        
        $this->load->library('captcha');        
        
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '');
            
            $this->form_validation->set_rules('login', 'lang:Логин', 'trim|required|xss_clean|min_length[4]|max_length[20]');
            $this->form_validation->set_rules('captcha', 'lang:Код с картинки', 'trim|required|callback__check_captcha');
            
            if($this->form_validation->run())
            {
                $this->load->model('forgotten_password_model');
                
                $login = $this->input->post('login', true);

                // Проверяю не востнавливал ли юзер пароль недавно
                $data_db_where = array(
                    'login' => $login,
                    'date >'  => date('Y-m-d H:i:s', time() - $this->config->item('forgotten_password_re_time') * 60),
                );
                
                $forgotten_history = $this->forgotten_password_model->get_row($data_db_where);
                
                if($forgotten_history)
                {
                    $this->_data['message'] = Message::info('В ближайшии :min мин. вы уже отправляли запрос на восстановление пароля, проверьте свой Email', array(
                        ':min' => $this->config->item('forgotten_password_re_time'),
                    ));
                }
                else
                {
                    $data_db_where = array(
                        'login' => $login,
                    );
                    
                    $login_data = $this->users_model->get_row($data_db_where);

                    if($login_data)
                    {
                        // Тип восстановления пароля
                        if($this->config->item('forgotten_password_type') == 'email')
                        {
                            // По Email
                            $hash = md5((time() * rand(1, 999)) . $login_data['email']);

                            $link = site_url('forgotten_password/step2/' . $hash);


                            $this->load->model('email_templates_model');

                            $message = $this->email_templates_model->get_template('forgotten_password_step1');

                            if(!$message)
                            {
                                $message['text'] = 'Письмо не найдено';
                                $message['title'] = 'Письмо не найдено';
                            }

                            $title = $message['title'];

                            $message = strtr($message['text'], array(
                                ':site_url'       => site_url(),
                                ':forgotten_link' => $link,
                            ));

                            $data_db = array(
                                'key'   => $hash,
                                'email' => $login_data['email'],
                                'login' => $login_data['login'],
                                'date'  => db_date(),
                            );
                            
                            // Чищю записи
                            $this->forgotten_password_model->del(array('login' => $login));
                            
                            if($this->forgotten_password_model->add($data_db))
                            {
                                if(send_mail($login_data['email'], $title, $message))
                                {
                                    $this->_data['message'] = Message::true('На Email указанный при регистрации отправлены инструкции по восстановлению пароля');
                                }
                                else
                                {
                                    log_message('error', 'Не удалось отправить письмо при восстановлении пароля шаг 1');
                                    $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
                                }
                            }
                            else
                            {
                                log_message('error', 'Не удалось сделать запись данных в БД, при восстановлении пароля шаг 1');
                                $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
                            }
                        }
                        else
                        {
                            // Вывод пароля на сайте

                            $this->load->helper('string');

                            $new_password = random_string('alnum', 6);

                            $data_db = array(
                                'password' => $this->auth->password_encript($new_password),
                            );

                            if($this->users_model->edit($data_db, $data_db_where))
                            {
                                $this->_data['message'] = Message::true('Ваш новый пароль: :password', array(
                                    ':password' => $new_password,
                                ));
                            }
                            else
                            {
                                log_message('error', 'Не удалось сделать запись нового пароля в БД, при восстановлении пароля шаг 1');
                                $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
                            }
                        }                
                    }
                    else
                    {
                        $this->_data['message'] = Message::false('Логин не найден');
                    }
                }
            }
        }
        
        
        $captcha = $this->captcha->get_img();
        $this->_data['captcha'] = $captcha['image'];
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
    
    public function step2()
    {
        $key = get_segment_uri(3);
        
        if($key == '')
        {
            redirect('forgotten_password');
        }
        
        
        $this->set_meta_title(lang('Восстановление пароля шаг 2'));
        
        $data_db_where = array(
            'key' => $key,
        );
        
        $this->load->model('forgotten_password_model');
        
        $data = $this->forgotten_password_model->get_row($data_db_where);
        
        if($data)
        {
            $this->load->helper('string');
            
            $new_password = random_string('alnum', rand(6, 10));
            
            $data_db = array(
                'password' => $this->auth->password_encript($new_password),
            );
            
            $data_db_where = array(
                'login' => $data['login'],
            );
            
            if($this->users_model->edit($data_db, $data_db_where))
            {
                $this->forgotten_password_model->del($data_db_where);
                
                
                $this->load->model('email_templates_model');

                $message = $this->email_templates_model->get_template('forgotten_password_step2');

                if(!$message)
                {
                    $message['text'] = 'Письмо не найдено';
                    $message['title'] = 'Письмо не найдено';
                }

                $title = $message['title'];

                $message = strtr($message['text'], array(
                    ':site_url' => site_url(),
                    ':password' => $new_password,
                ));
                
                
                if(send_mail($data['email'], $title, $message))
                {
                    $this->_data['message'] = Message::true('На Email указанный при регистрации отправлен новый пароль');
                }
                else
                {
                    log_message('error', 'Не удалось отправить письмо при восстановлении пароля шаг 2');
                    $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
                }
            }
            else
            {
                log_message('error', 'Не удалось сделать запись нового пароля в БД, при восстановлении пароля шаг 2');
                $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
            }
        }
        else
        {
            $this->_data['message'] = Message::false('Ключ восстановления пароля неправильный');
        }        
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
}