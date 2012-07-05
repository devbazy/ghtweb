<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Telnet extends Controllers_Backend_Base
{
    public function __construct()
    {
        parent::__construct();
        
        $class = strtolower(__CLASS__);
        //$this->_model = $class . '_model';
        
        $this->_data['server_list'] = $this->servers_model->get_servers_name();
    }
    
    
	public function index()
	{
        if(isset($_POST['submit']))
        {
            // Отправка команды
            if($this->_data['server_list'])
            {
                $server_id = key($this->_data['server_list']);

                if(count($this->_data['server_list']) > 1)
                {
                    $server_id = (int) $this->input->post('server_id');
                }

                // Если настроек телнета у сервера нет то die
                $servers_config = $this->config->item($server_id, 'servers');

                $telnet_host = $servers_config['telnet_host'];
                $telnet_port = $servers_config['telnet_port'];
                $telnet_pass = $servers_config['telnet_pass'];

                if($telnet_host == '' || $telnet_port == '')
                {
                    $this->_data['message'] = Message::false('Для выбранного сервера настройки для TELNET не установлены <br /><a href=":link" target="_blank">перейти к настройкам сервера</a>', array(
                        ':link' => '/backend/servers/edit/' . $server_id . '/#telnet',
                    ));
                }
                elseif(!$this->input->post('command', true))
                {
                    $this->_data['message'] = Message::false('Необходимо ввести команду');
                }
                else
                {
                    $command = iconv('utf-8', 'cp1251', $this->input->post('command', true));

                    $config = array(
                        'host' => $telnet_host,
                        'port' => $telnet_port,
                        'pass' => $telnet_pass,
                    );

                    $this->load->library('telnet_', $config);

                    if($this->telnet_->send_command($command))
                    {
                        $this->_data['message'] = Message::true('Команда отправлена');
                    }
                    else
                    {
                        if($this->telnet_->get_errors())
                        {
                            $this->_data['message'] = Message::false($this->telnet_->get_errors());
                        }
                        else
                        {
                            $this->_data['message'] = Message::false('Неверная команда');
                        }
                    }
                }
            }
            else
            {
                $this->_data['message'] = Message::info('Для управления нужно добавить хотябы один сервер');
            }
        }
        
        $this->tpl(__CLASS__ . '/' . __FUNCTION__);
    }
}