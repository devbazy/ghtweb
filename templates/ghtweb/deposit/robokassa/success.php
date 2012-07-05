<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Пополнение баланса'), 'current' => true),
    ),
)) ?>

<?php if($status) { ?>
    <?php echo msg(lang('Ваш баланс пополнен.'), 'true') ?>
<?php } else { ?>
    <?php echo msg(lang('Платёж не найден'), 'false') ?>
<?php } ?>