<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Восстановление пароля шаг 2'), 'current' => true),
    ),
)) ?>


<?php echo $message ?>