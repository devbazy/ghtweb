<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Пополнение баланса'), 'current' => true),
    ),
)) ?>


<?php echo Message::info('Модуль отключён') ?>