<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Deposit extends CI_Driver_Library
{
    public $valid_drivers = array('Deposit_robokassa');
    
    private $_CI;
    private $_type;

    
    
    public function __construct()
    {
        $this->_CI =& get_instance();
        
        $this->_CI->config->load('deposit', true);
        
        $this->_type = $this->_CI->config->item('driver', 'deposit');
        
        $this->_CI->lang->load('deposit', $this->_CI->config->item('language'));

        $this->_CI->load->add_package_path(APPPATH . 'modules/deposit', true);
    }
    
    public function get_form()
    {
        //$this->_CI->load->add_package_path(APPPATH . 'modules/deposit', true);
        $view = $this->_CI->load->view($this->_type . '/form', NULL, true);
        //$this->_CI->load->remove_package_path(APPPATH . 'modules/deposit', true);

        return $view;
    }
    
    /**
     * Подтверждение платежа
     * 
     * @param string $login
     * @param integer $count
     * @param integer $order: Номер счёта
     * @param integer $sum: Сколько надо отдать
     * 
     * @return string
     */
    public function get_confirmation(array $data)
    {
        $data['inputs'] = $this->{$this->_type}->get_hidden_inputs($data);
        $data['form_url'] = $this->{$this->_type}->get_form_url();

        return $this->_CI->load->view($this->_type . '/confirmation', $data, true);
    }
    
    /**
     * Логирование платежа
     * 
     * @param array $data
     * 
     * @return integer
     */
    public function logging(array $data)
    {
        return $this->{$this->_type}->{__FUNCTION__}($data);
    }

    /**
     * Возвращает данные об операции
     *
     * @param integer $order_id
     */
    public function get_order($order_id)
    {
        return $this->{$this->_type}->{__FUNCTION__}($order_id);
    }

    /**
     * Проверка подписи
     */
    public function check_signature()
    {
        return $this->{$this->_type}->{__FUNCTION__}();
    }
}