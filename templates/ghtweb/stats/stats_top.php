<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th><?php echo lang('Имя персонажа') ?></th>
            <th><?php echo lang('Кол-во ПВП') ?></th>
            <th><?php echo lang('Клан') ?></th>
            <th><?php echo lang('Время в игре') ?></th>
            <th><?php echo lang('Статус') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($content) { ?>
            <?php foreach($content as $row) { ?>
                <tr>
                    <td width="30%"><font color="#9D6A1E"><?php echo $row['char_name'] ?></font>
                        <p class="desc" style="font-size: 11px;"><?php echo get_class_name_by_id($row['class_id']) ?> [<?php echo $row['level'] ?>]</p></td>
                    <td width="20%"><?php echo $row['pvpkills'] ?></td>
                    <td width="20%"><?php
                    $clan_link = $row['clan_name'];
                    
                    if($clan_info)
                    {
                        $clan_link = anchor('stats/' . $server_id . '/clan_info/' . $row['clan_id'], $row['clan_name']);
                    }
                    
                    echo ($row['clan_name'] == '' ? lang('нет клана') : $clan_link);
                    ?></td>
                    <td><?php echo ($row['onlinetime'] > 0 ? online_time($row['onlinetime']) : lang('в игру не заходил')) ?></td>
                    <td><?php echo ($row['online'] ? '<span class="green">online</span>' : '<span class="red">offline</span>') ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
            	<td colspan="5"><?php echo lang('Данных нет') ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>