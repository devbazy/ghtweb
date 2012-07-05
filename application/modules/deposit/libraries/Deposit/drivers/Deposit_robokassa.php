<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Deposit_robokassa extends CI_Driver
{
    private $_CI;



    public function __construct()
    {
        $this->_CI =& get_instance();

        $this->_CI->load->model('deposit_robokassa_model');
        $this->_CI->load->config('deposit_robokassa', true);
    }

    public function logging(array $data)
    {
        return $this->_CI->deposit_robokassa_model->add($data);
    }

    public function get_order($order_id)
    {
        $order_id = (int) $order_id;

        return $this->_CI->deposit_robokassa_model->get_row(array('id' => $order_id));
    }

    public function get_hidden_inputs(array $data)
    {
        $data = array(
            'login'        => $this->_CI->config->item('robokassa_login'),
            'password1'    => $this->_CI->config->item('robokassa_password'),
            'item_id'      => $data['item_id'],
            'in_curr'      => 'WMRM',
            'desc'         => $this->_CI->config->item('robokassa_description'),
            'lang'         => $this->_CI->config->item('language'),
            'count_item'   => $data['count_item'],
            'order_number' => $data['id'],
            'sum'          => $data['sum'],
        );

        $SignatureValue = md5($data['login'] . ':' . $data['sum'] . ':' . $data['order_number'] . ':' . $data['password1'] . ':Shp_item=' . $data['item_id']);

        $inputs = '
            <input type="hidden" name="MrchLogin" value="' . $data['login'] . '">
            <input type="hidden" name="OutSum" value="' . $data['sum'] . '">
            <input type="hidden" name="InvId" value="' . $data['order_number'] . '">
            <input type="hidden" name="Desc" value="' . $data['desc'] . '">
            <input type="hidden" name="SignatureValue" value="' . $SignatureValue . '">
            <input type="hidden" name="Shp_item" value="' . $data['item_id'] . '">
            <input type="hidden" name="IncCurrLabel" value="' . $data['in_curr'] . '">
            <input type="hidden" name="Culture" value="' . $data['lang'] . '">';

        return $inputs;
    }

    public function get_form_url()
    {
        return $this->_CI->config->item('form_url', 'deposit_robokassa');
    }

    public function check_signature()
    {
        $get = $this->_CI->input->get();

        $data = array(
            'InvId'          => $get['InvId'],
            'OutSum'         => $get['OutSum'],
            'SignatureValue' => strtoupper($get['SignatureValue']),
            'Culture'        => $get['Culture'],
            'Shp_item'       => $get['Shp_item'],
            'password1'      => $this->_CI->config->item('robokassa_password'),
        );

        $my_crc = strtoupper(md5($data['OutSum'] . ':' . $data['InvId'] . ':' . $data['password1'] . ':Shp_item=' . $data['Shp_item']));

        if($data['SignatureValue'] == $my_crc)
        {
            $data_db_where = array(
                'id'     => $data['InvId'],
                'status' => '0',
            );

            $deal = $this->_CI->deposit_robokassa_model->get_row($data_db_where);

            if($deal)
            {
                // Зарываю сделку как завершенную
                $data_db = array(
                    'status' => '1',
                );

                $this->_CI->deposit_robokassa_model->edit($data_db, $data_db_where);

                return $deal;
            }
        }

        return false;
    }
}