<div class="page-header">
    <h1>Персонажи <small>на аккаунте</small> <span class="badge badge-info"><?php echo get_segment_uri(5) ?></span> <small>сервер</small> <span class="badge badge-info"> <?php echo $this->_data['server_list'][get_segment_uri(3)] ?></span> <small>кол-во</small> <span class="badge badge-info"><?php echo $count ?></span></h1>
</div>

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
                <td><?php echo $row['account_name'] ?></td>
            	<td><?php echo ($row['clan_name'] == '' ? 'нет' : $row['clan_name']) ?></td>
            	<td><?php echo get_class_name_by_id($row['class_id']) ?></td>
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