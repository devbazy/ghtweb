<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Captcha
{
    private $_CI;
    
    /**
     * @var array: настройки
     */
    private $_options = array();
    
    
    
    public function __construct()
    {
        $this->_CI =& get_instance();
        
        $this->_CI->config->load('captcha', true);
        
        $this->_options = $this->_CI->config->item('captcha');
        
        $this->_options['img_path']  = rtrim($this->_options['img_path'], '/') . '/';
        $this->_options['font_path'] = rtrim($this->_options['font_path'], '/') . '/';
        
        $this->_CI->load->library('session');
        
        $this->_CI->lang->load('captcha', $this->_CI->config->item('language'));
        
        $this->_CI->load->helper('language');
        
        if($this->_options['length'] != 'rand' && $this->_options['length'] > 7)
        {
            $this->_options['length'] = 7;
        }
        elseif($this->_options['length'] == 'rand')
        {
            $this->_options['length'] = rand(3,7);
        }
            
        
        // Проверка данных
        if(!is_dir($this->_options['img_path']))
        {
            return false;
        }
        
        if(!is_dir($this->_options['font_path']))
        {
            return false;
        }
        
        if(!is_really_writable($this->_options['img_path']))
        {
            return false;
        }
    }
    
    /**
     * Генерация картинки
     * 
     * @return array
     */
    private function generate()
    {
        // Удаление старых картинок
        list($usec, $sec) = explode(" ", microtime());
        $now = ((float)$usec + (float)$sec);
        
        $current_dir = @opendir($this->_options['img_path']);
        
        while ($filename = @readdir($current_dir))
        {
            if ($filename != '.' && $filename != '..' && $filename != 'index.html' && $filename != 'fonts')
            {
                $name = str_replace('.jpg', '', $filename);
                
                if (($name + $this->_options['expiration']) < $now)
                {
                    @unlink($this->_options['img_path'] . $filename);
                }
            }
        }
        
        @closedir($current_dir);
        
        
        // Генерация картинки
        $letters     = array('a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','s','t','u','v','w','x','y','z','2','3','4','5','6','7','9');
        $colors      = range(0, 160, 20);
        $backgrounds = $colors;
        
        // Фон
        $holst = imagecreatetruecolor($this->_options['img_width'], $this->_options['img_height']);
        $fon   = imagecolorallocate($holst, 255, 255, 255);
		imagefill ($holst, 0, 0, $fon);
        
        
        // Помехи на фоне
        // @TODO
        for($i = 0; $i < $this->_options['lines']; $i++)
        {
            $x1 = rand(0, $this->_options['img_width']);
            $x2 = rand($x1, $this->_options['img_width']);
            $y1 = rand(0, $this->_options['img_height']);
            $y2 = rand($y1, $this->_options['img_height']);
            
            $color = imagecolorallocate($holst, $colors[rand(0, count($colors)-1)], $colors[rand(0, count($colors)-1)], $colors[rand(0, count($colors)-1)]);
            
            imageline($holst, $x1, $y1, $x2, $y2, $color);
        }
        
        
        
        $cod = array();
        
        $width_word = $this->_options['font_size'] * $this->_options['length'];
        
        // Текст
        for($i = 0; $i < $this->_options['length']; $i++)
		{
            $color    = imagecolorallocate($holst, $colors[rand(0, count($colors)-1)], $colors[rand(0, count($colors)-1)], $colors[rand(0, count($colors)-1)]);
            $letter   = $letters[rand(0, count($letters)-1)];
            $cod[]    = $letter;
            $scale    = rand(-20, 20);
            $offset_x = (($this->_options['img_width'] - $width_word) / 2);
            $x        = $offset_x + ($i * $this->_options['font_size']) + 1;
			$y        = (($this->_options['img_height'] / 2) + ($this->_options['font_size'] / 2)) - 2;
            imagettftext($holst, $this->_options['font_size'], $scale, $x, $y, $color, $this->_options['font_path'] . $this->_options['font'], $letter);
        }
        
        // Слово
        $word = implode('', $cod);
        
        // Session
        $this->_CI->session->unset_userdata('captcha_word');
        $this->_CI->session->unset_userdata('captcha_id');
        
        $this->_CI->session->set_userdata('captcha_word', $word);
        $this->_CI->session->set_userdata('captcha_id', $now);
        
        
        
        $img_name = $now.'.jpg';
        
        imagepng($holst, $this->_options['img_path'] . $img_name);
        imagedestroy($holst);
        
        $img_src = rtrim(base_url(), '/') . '/' . str_replace(FCPATH, '', $this->_options['img_path']) . $img_name;
        
		$img = '<img src="' . $img_src . '" width="' . $this->_options['img_width'] . '" height="' . $this->_options['img_height'] . '" alt="' . lang('Нажмите чтобы обновить картинку') . '" title="' . lang('Нажмите чтобы обновить картинку') . '" /><input type="hidden" name="captcha_id" value="' . $now . '" />';

        $this->_options['time'] = $now;
        
        return array('word' => $word, 'image' => $img);
    }
    
    /**
     * Возвращает картинку
     * 
     * @return string
     */
    public function get_img()
    {
        return $this->generate();
    }
    
    /**
     * Проверка
     * 
     * @return boolean
     */
    public function check_captcha($word, $id)
    {
        $s_word = (string) $this->_CI->session->userdata('captcha_word');
        $s_id   = (string) $this->_CI->session->userdata('captcha_id');
           
        if(!file_exists($this->_options['img_path'] . $id . '.jpg'))
        {
            return false;
        }
        
        if($s_word == $word && $s_id == $id)
        {
            return true;
        }
        
        return false;
    }
}