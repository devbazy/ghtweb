<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Активация аккаунта'), 'current' => true),
    ),
)) ?>


<?php echo $message ?>