<?php

//Корневая директория сайта
define('DIR_ROOT',		$_SERVER['DOCUMENT_ROOT']);
//Директория с изображениями (относительно корневой)
define('DIR_IMAGES',	'/uploads/tiny_mce/images');
//Директория с файлами (относительно корневой)
define('DIR_FILES',		'/uploads/tiny_mce/files');


//Высота и ширина картинки до которой будет сжато исходное изображение и создана ссылка на полную версию
define('WIDTH_TO_LINK', 600);
define('HEIGHT_TO_LINK', 600);

//Атрибуты которые будут присвоены ссылке (для скриптов типа lightbox)
define('CLASS_LINK', '');
define('REL_LINK', '');

date_default_timezone_set('Europe/Moscow');