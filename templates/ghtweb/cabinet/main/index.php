<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Личный кабинет'), 'current' => true),
    ),
)) ?>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<ul class="unstyled cabinet-main-info">
    <li>- <?php echo lang('Последний раз Вы заходили :lastlogin с IP :lastip', array(
        ':lastlogin' => '<span class="label label-info">' . $this->auth->get('last_access') . '</span>',
        ':lastip'    => '<span class="label label-info">' . $this->auth->get('last_ip') . '</span>',
    )) ?></li>
    <li>- <?php echo lang('Дата регистрации аккаунта') ?> <span class="label label-info"><?php echo $this->auth->get('joined') ?></span></li>
    <li>- <?php echo lang('Баланс') ?> <span class="label label-info"><?php echo $this->auth->get('money') ?></span> <?php echo $this->config->item('shop_money_name') ?> (<?php echo anchor('payment_systems', lang('Пополнить')) ?>)</li>
    <li>- <?php echo lang('Игровых аккаунтов :count из :total', array(
        ':count' => '<span class="label label-info">' . $count_game_accounts . '</span>',
        ':total' => '<span class="label label-info">' . $this->config->item('count_game_accounts_allowed') . '</span>',
    )) ?>
    <li>- <?php echo lang('Основной Email') ?> <span class="label label-info"><?php echo $this->auth->get('email') ?><span></li>
    <li>- <?php echo lang('Привязка аккаунта к IP') ?>: <?php echo ($this->auth->get('protected_ip') == '' ? '<span class="red">' . lang('отключена') . '</span>' : '<span class="label label-info">' . $this->auth->get('protected_ip') . '</span>') ?></li>
</ul>