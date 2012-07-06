<div class="page-header">
    <h1>Персонажи <small>просмотр</small> <span class="badge badge-info"><?php echo $count ?></span></h1>
    <div class="right" style="margin: -15px 0 0;">
        <?php if($server_list) { ?>
            <?php foreach($server_list as $server_id => $server_name) { ?>
                <a <?php echo $this->_data['server_id'] == $server_id ? '' : ('href="/backend/characters/' . $server_id . '/"') ?> class="btn btn-info btn-mini <?php echo ($this->_data['server_id'] == $server_id ? 'disabled' : '') ?>"><?php echo $server_name ?></a>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<?php echo form_open('', 'class="form-horizontal" method="get" style="margin: 0;"') ?>
    <fieldset>
        <div class="control-group">
            <input type="text" name="char_name" value="<?php echo $this->input->get('char_name') ?>" placeholder="Имя персонажа" />
            <input type="text" name="account_name" value="<?php echo $this->input->get('account_name') ?>" placeholder="Логин" />
            <input type="text" name="level" class="span1" value="<?php echo $this->input->get('level') ?>" placeholder="Уровень" />
            <button class="btn btn-primary" type="submit">Искать</button>
            <a href="/<?php echo $this->uri->uri_string() ?>/" class="btn">Сброс</a>
        </div>
    </fieldset>
<?php echo form_close() ?>

<?php echo $message ?>

<table class="table table-striped table-bordered">
    <tr>
        <th width="3%">#</th>
        <th width="26%">Имя персонажа</th>
        <th width="15%">Логин</th>
        <th width="15%">Клан</th>
        <th width="15%">Клас</th>
        <th width="10%">Время в игре</th>
        <th width="7%">Online</th>
        <th width="4%"></th>
    </tr>
    <?php if($content) { ?>
        <?php $oO = (!empty($_GET['per_page']) ? (int) $_GET['per_page'] + 1 : 1); foreach($content as $row) { ?>
            <tr>
                <td><?php echo $oO ?></td>
            	<td><?php echo $row['char_name'] ?> (<?php echo $row['level'] ?>)</td>
                <td><a href="/backend/characters/<?php echo $this->_data['server_id'] ?>/characters_in_account/<?php echo $row['account_name'] ?>/" rel="tooltip" title="Посмотреть всех персонажей на аккаунте"><?php echo $row['account_name'] ?></a></td>
            	<td><?php echo $row['clan_name'] ?></td>
            	<td><?php echo get_class_name_by_id($row['classid']) ?></td>
                <td><?php echo online_time($row['onlinetime']) ?></td>
                <td><?php echo ($row['online'] ? '<span class="green">online</span>' : '<span class="red">offline</span>') ?></td>
                <td>
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu" style="z-index: 999;">
                                <li><a href="/backend/characters/<?php echo $this->_data['server_id'] ?>/items/<?php echo $row['char_id'] ?>/"><i class="icon-user"></i> Посмотреть предметы</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </td>
            </tr>
        <?php $oO++; } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="8">Персонажи не найдены</td>
        </tr>
    <?php } ?>

</table>

<?php echo $pagination ?>