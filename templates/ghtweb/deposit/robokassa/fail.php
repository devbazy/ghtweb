<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Пополнение баланса'), 'current' => true),
    ),
)) ?>


<?php echo msg(lang('Ошибка пополнения баланса'), 'false') ?>