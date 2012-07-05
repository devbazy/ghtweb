<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$config = array(
    'font'        => 'Aggloria_Roman.ttf', // Шрифт
    'font_size'   => 16, // Размер шрифта
    'font_path'   => FCPATH . 'captcha/fonts', // Папка с шрифтами
    'length'      => 5, // Кол-во символов (rand - рандомное кол-во, от 3 до 7), максимум 7
    'img_path'    => FCPATH . 'captcha', // Папка где будут лежать картинки с капчей
    'img_width'   => 100, // Ширина картинки
    'img_height'  => 30,  // Высота картинки
    'expiration'  => 300,  // Через какое время картинка будет не действительна (в секундах)
    'lines'       => 5,  // Кол-во линий на заднем фоне
);