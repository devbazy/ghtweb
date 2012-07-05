<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Shop extends Controllers_Cabinet_Base
{
    public function __construct()
    {
        parent::__construct();
        
        
        if(!$this->config->item('shop_allow'))
        {
            $this->session->set_flashdata('message', Message::info('Модуль магазина отключен'));
            redirect('cabinet');
        }
        
        $this->load->model('shop_products_model');
    }
    
	public function index()
	{
        $this->_data['content'] = $this->shop_products_model->get_all_products();
        
        
		$this->tpl(__CLASS__ . '/' . __FUNCTION__);
	}
    
    /**
     * Покупка товара
     */
    public function buy()
    {
        if(!isset($_POST['submit']))
        {
            redirect('cabinet/shop');
        }
        
        // Если нет денег
        if($this->auth->get('money') == 0)
        {
            $this->session->set_flashdata('message', Message::false('У Вас нулевой баланс, Вы не можете покупать товары. :link_deposit', array(
                ':link_deposit' => anchor('cabinet/deposit', lang('Пополнить баланс')),
            )));
            
            redirect('cabinet/shop');
        }
        
        $items = $this->input->post('items');

        // Если товары были выбраны
        if($items)
        {
            $items_data = $this->shop_products_model->get_all_products($items);
            
            if($items_data)
            {
                $data_db = array();
                
                $user_id = $this->auth->get('user_id');
                
                $amount = 0;
                
                $data_db_stats = array();
                
                foreach($items_data as $category => $products)
                {
                    foreach($products as $product)
                    {
                        $data_db[] = array(
                            'user_id'   => $user_id,
                            'item_id'   => $product['item_id'],
                            'count'     => $product['count'],
                            'price'     => $product['price'],
                            'date'      => db_date(),
                        );
                        
                        // Данные для статистики
                        $data_db_stats[] = array(
                            'user_id'   => $user_id,
                            'item_id'   => $product['item_id'],
                            'count'     => $product['count'],
                            'price'     => $product['price'],
                            'user_ip'   => $this->input->ip_address(),
                            'date'      => db_date(),
                        );
                        
                        $amount += $product['price'];
                    }
                }
                
                
                // Проверяю хватит ли денег у пользователя
                if($amount > $this->auth->get('money'))
                {
                    $this->session->set_flashdata('message', Message::info('У Вас не хватает баланса для совершения сделки'));
                }
                else
                {
                    $this->load->model('users_warehouse_model');

                    $this->load->model('shop_product_payments_model');

                    // Транзакция
                    $this->db->trans_start();
                    
                        // Добавляю товары на склад пользователю
                        $this->users_warehouse_model->insert($data_db);

                        // Забираю деньги у пользователя
                        $this->auth->set(array(
                            'money' => ($this->auth->get('money') - $amount),
                        ), true);

                        // Записываю лог о сделке
                        $this->shop_product_payments_model->insert_batch($data_db_stats);
                    
                    $this->db->trans_complete();
                    
                    if($this->db->trans_status() !== FALSE)
                    {
                        $this->session->set_flashdata('message', Message::true('Вы успешно купили товар(ы)'));
                    }
                    else
                    {
                        $this->session->set_flashdata('message', Message::false('Ошибка! Не удалось записать данные в БД'));
                    }
                }
            }
            else
            {
                $this->session->set_flashdata('message', Message::false('Товар(ы) не найден(ы)'));
            }
        }
        else
        {
            $this->session->set_flashdata('message', Message::false('Чтобы купить товар(ы) нужно сперва их выбрать'));
        }
        
        redirect('cabinet/shop');
    }
}