<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Payment_systems extends Controllers_Frontend_Base
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->driver('deposit');
        
        $this->set_meta_title(lang('Пополнение баланса'));
        
        if(!$this->config->item('robokassa_allow') && strpos($_SERVER['REQUEST_URI'], 'disabled') === false)
        {
            redirect('payment_systems/disabled');
        }
    }


    public function index()
    {
        $this->_data['content'] = $this->deposit->get_form();

        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_error_delimiters('', '<br />');
            
            $this->form_validation->set_rules('login', 'lang:Логин', 'trim|required|xss_clean|min_length[4]|max_length[20]|callback__check_user_login');
            $this->form_validation->set_rules('count', 'lang:Количество', 'required|is_natural_no_zero');
            
            if($this->form_validation->run())
            {
                $count   = $this->input->post('count');
                $sum     = ($count * (int) $this->config->item('shop_items_sum'));
                $item_id = 1;
                
                // Записываю лог о сделке
                $data_db = array(
                    'sum'        => $sum,
                    'item_id'    => $item_id,
                    'count_item' => $count,
                    'status'     => '0',
                    'ip'         => $this->input->ip_address(),
                    'user_id'    => $this->auth->get('user_id'),
                    'to_login'   => $this->input->post('login', true),
                    'date'       => db_date(),
                );
                
                if(($order_number = $this->deposit->logging($data_db)))
                {
                    $data_session = array(
                        'deposit_order' => $order_number,
                    );

                    $this->session->set_userdata($data_session);

                    redirect('payment_systems/confirmation');
                }
                else
                {
                    $this->_data['message'] = Message::false('Ошибка! Обратитесь к Администрации сайта');
                }
            }
            
            if(validation_errors())
            {
                Message::$_translate = false;
                $this->_data['message'] = Message::false(validation_errors());
                Message::$_translate = true;
            }
        }
        

        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
    
    /**
     * Подтверждение платежа
     */
    public function confirmation()
    {
        // Проверка логина и кол-ва
        $order = (int) $this->session->userdata('deposit_order');
        
        if($order < 1)
        {
            redirect('payment_systems');
        }

        $this->set_meta_title(lang('Пополнение баланса - Подтверждение платежа'));

        $order_info = $this->deposit->get_order($order);

        if($order_info)
        {
            $content = $this->deposit->get_confirmation($order_info);
        }
        else
        {
            $content = Message::false('Данные транзакции не найдены');
        }

        $this->_data['content'] = $content;


        $this->tpl(__CLASS__ . '/index');
    }
    
    /**
     * Проверка логина
     */
    public function _check_user_login()
    {
        $data_db_where = array(
            'login' => $this->input->post('login', true),
        );
        
        if(!$this->users_model->get_row($data_db_where))
        {
            $this->form_validation->set_message('_check_user_login', lang('Логин не найден'));
            return false;
        }
        
        return true;
    }
    
    /**
     * Модуль отключён
     */
    public function disabled()
    {
        if($this->config->item('robokassa_allow'))
        {
            redirect('payment_systems');
        }
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }

    public function back()
    {
        $this->session->unset_userdata('deposit_order');
        redirect('payment_systems');
    }

    public function success()
    {
        if(($deal = $this->deposit->check_signature()))
        {
            // Добавляю юзеру монет
            $this->db->set('money', 'money + ' . $deal['count_item'], false);
            $this->db->where('login', $deal['to_login']);
            $this->db->limit(1);

            if($this->db->update('users'))
            {
                $this->session->unset_userdata('deposit_order');
                $content = Message::true('Ваш баланс пополнен.');
            }
        }
        else
        {
            $content = Message::false('Платёж не найден');
        }

        $this->_data['content'] = $content;


        $this->tpl(__CLASS__ . '/index');
    }

    public function fail()
    {
        $this->_data['content'] = Message::false('Ошибка транзакции');
        $this->session->unset_userdata('deposit_order');

        $this->tpl(__CLASS__ . '/index');
    }
}