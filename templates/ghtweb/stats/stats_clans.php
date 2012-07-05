<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="30%"><?php echo lang('Название клана') ?></th>
            <th width="10%"><?php echo lang('Уровень') ?></th>
            <th width="20%"><?php echo lang('Замок') ?></th>
            <th width="10%"><?php echo lang('Игроков') ?></th>
            <th width="10%"><?php echo lang('Репутация') ?></th>
            <th width="20%"><?php echo lang('Альянс') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($content) { ?>
            <?php foreach($content as $row) { ?>
                <tr>
                    <td><font color="#9D6A1E"><?php
                    if($stats_clan_info)
                    {
                        echo anchor('stats/' . $server_id . '/clan_info/' . $row['clan_id'], $row['clan_name']);
                    }
                    else
                    {
                        echo $row['clan_name'];
                    }
                    ?></font><p class="desc" style="font-size: 11px;"><?php echo lang('Лидер') ?>: <?php echo $row['char_name'] ?></p></td>
                    <td><?php echo $row['clan_level'] ?></td>
                    <td><?php echo get_castle_name($row['hasCastle']) ?></td>
                    <td><?php echo $row['ccount'] ?></td>
                    <td><?php echo number_format($row['reputation_score'], 0, '', '.') ?></td>
                    <td><?php echo ($row['ally_name'] != '' ? $row['ally_name'] : lang('нет')) ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
            	<td colspan="6"><?php echo lang('Данных нет') ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>