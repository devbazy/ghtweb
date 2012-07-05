<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Личный кабинет'), 'url' => 'cabinet'),
        array('name' => lang('Игровые аккаунты'), 'url' => 'cabinet/game_accounts'),
        array('name' => lang('Просмотр аккаунта'), 'current' => true),
    ),
)) ?>


<div class="page-header">
    <h1><?php echo lang('Сервер') ?>: <?php echo $this->_l2_settings['servers'][get_segment_uri(4)]['name'] ?> <small><?php echo lang('Аккаунт') ?>: <?php echo get_segment_uri(5) ?></small></h1>
</div>

<?php echo $message ?>

<h3><?php echo lang('Персонажи на аккаунте') ?></h3><br />

<!-- <?php echo (isset($errors_tp) ? $errors_tp : '') ?>
<?php echo (isset($info_tp) ? $info_tp : '') ?> -->

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="51%"><?php echo lang('Имя') ?></th>
            <th width="10%"><?php echo lang('Статус') ?></th>
            <th width="17%"><?php echo lang('Время в игре') ?></th>
            <th width="22%"></th>
        </tr>
    </thead>
    <tbody>

    <!-- список персонажей -->
    <?php if($characters) { ?>
        <?php foreach($characters as $row) { ?>
            <tr>
                <td><?php echo $row['char_name'] ?><p class="desc">[<?php echo get_class_name_by_id($row['class_id']) ?> <?php echo $row['level'] ?>]</p></td>
                <td><?php echo ($row['online'] ? '<span class="green">' . lang('online') . '</span>' : '<span class="red">' . lang('offline') . '</span>') ?></td>
                <td><?php echo online_time($row['onlinetime']) ?></td>
                <td>
                    <!-- ТЕЛЕПОРТ -->
                    <?php echo form_open() ?>
                        <input type="hidden" name="city_id" value="1" />
                        <input type="hidden" name="char_id" value="<?php echo $row['char_id'] ?>" />
                        <div class="btn-toolbar right">
                            <div class="btn-group">
                                <button class="btn btn-mini btn-info" type="submit" name="submitTP">Телепорт в город</button>
                                <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle btn-info"><span class="caret"></span></button>
                                <ul class="dropdown-menu city-for-tp">
                                    <?php foreach($city_teleports as $id => $name) { ?>
                                        <li><a city-id="<?php echo $id ?>"><?php echo $name ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div><!-- /btn-group -->
                        </div>
                    <?php echo form_close() ?>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="4"><?php echo lang('Персонажей нет') ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>