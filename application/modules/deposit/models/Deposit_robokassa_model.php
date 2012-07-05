<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Deposit_robokassa_model extends Crud
{
    public $_table = 'robokassa_payments';

    private $_fields = array('sum', 'count_item', 'item_id', 'status', 'ip', 'user_id', 'to_login');



    public function get_fields()
    {
        return $this->_fields;
    }
}