<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Личный кабинет'), 'url' => 'cabinet'),
        array('name' => lang('Игровые аккаунты'), 'url' => 'cabinet/game_accounts'),
        array('name' => lang('Информация о персонаже'), 'current' => true),
    ),
)) ?>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<?php if(!$this->session->flashdata('message') && $message != '') { ?>
    <?php echo $message ?>
<?php } ?>

<table class="table table-striped table-bordered">
    <tr>
        <th colspan="4"><?php echo lang('Информация о персонаже') ?></th>
    </tr>
    <tr>
        <td><b><?php echo lang('Персонаж') ?>:</b> <?php echo $character_data['char_name'] ?> <img src="/templates/<?php echo $this->config->item('template') ?>/images/<?php echo $character_data['sex'] ?>.png" alt=""></td>
        <td><b><?php echo lang('Уровень') ?>:</b> <?php echo $character_data['level'] ?></td>
        <td><b><?php echo lang('Здоровье') ?>:</b> <?php echo $character_data['curHp'] ?></td>
        <td><b><?php echo lang('Мана') ?>:</b> <?php echo $character_data['curMp'] ?></td>
    </tr>
    <tr>
        <td><b><?php echo lang('Карма') ?>:</b> <?php echo $character_data['karma'] ?></td>
        <td><b><?php echo lang('ПВП/ПК') ?>:</b> <?php echo $character_data['pvpkills'] ?>/<?php echo $character_data['pkkills'] ?></td>
        <td><b><?php echo lang('Время в игре') ?>:</b> <?php echo online_time($character_data['onlinetime']) ?></td>
        <td><b><?php echo lang('Клан') ?>:</b> <?php echo ($this->_l2_settings['servers'][get_segment_uri(3)]['stats_clan_info'] ? anchor('stats/' . get_segment_uri(3) . '/clan_info/' . $character_data['clan_id'], $character_data['clan_name'], 'target="_blank"') : $character_data['clan_name']) ?></td>
    </tr>
    <tr>
        <td><b>Exp:</b> <?php echo $character_data['exp'] ?></td>
        <td><b>Sp:</b> <?php echo $character_data['sp'] ?></td>
        <td><b><?php echo lang('Класс') ?>:</b> <?php echo get_class_name_by_id($character_data['class_id']) ?></td>
        <td><b><?php echo lang('Раса') ?>:</b> <?php echo get_race_name_by_id($character_data['race']) ?></td>
    </tr>
</table>

<table class="table table-striped table-bordered">
    <tr>
        <th colspan="4"><?php echo lang('Предметы') ?></th>
    </tr>
    <tr>
        <th width="8%"></th>
        <th width="60%"><?php echo lang('Название') ?></th>
        <th width="20%"><?php echo lang('Кол-во') ?></th>
        <th width="12%"><?php echo lang('Заточка') ?></th>
    </tr>
    <?php if($items) { ?>
        <?php foreach($items as $item) { ?>
            <tr>
                <td><?php echo (file_exists(FCPATH . 'resources/images/items/' . $item['item_id'] . '.gif') ? '<img src="/resources/images/items/' . $item['item_id'] . '.gif" width="32" height="32" />' : '<img src="/resources/images/items/blank.gif" width="32" height="32" />') ?></td>
                <td><?php echo $item['name'] ?></td>
                <td><?php echo number_format($item['count'], 0, '', '.') ?></td>
                <td><?php echo '<font color="' . definition_enchant_color($item['enchant_level']) . '">' . $item['enchant_level'] . '</font>' ?></td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="4"><?php echo lang('Предметы не найдены') ?></td>
        </tr>
    <?php } ?>
</table>