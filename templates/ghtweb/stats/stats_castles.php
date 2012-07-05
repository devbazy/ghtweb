<table class="table table-striped table-bordered">
    <tbody>
        <?php foreach($content as $row) { ?>
            <tr>
                <td width="26%"><h3><?php echo $row['name'] ?></h3><img src="/resources/images/castles/<?php echo $row['castle_id'] ?>.jpg" alt="" /></td>
                <td width="74%">
                <?php echo lang('Налог') ?>: <span class="label label-info"><?php echo $row['tax_percent'] ?>%</span><br />
                <?php echo lang('Дата осады') ?>: <span class="label label-info"><?php echo date('Y-m-d H:i:s', substr($row['sieg_date'], 0, 10)) ?></span><br />
                <?php echo lang('Владелец') ?>: <?php echo ($row['owner'] ? ($stats_clan_info ? anchor('stats/' . $server_id . '/clan_info/' . $row['owner_id'], $row['owner']) : $row['owner']) : '<span class="label label-info">NPC</span>') ?> <br />
                <?php echo lang('Нападающие') ?>:
                <?php
                $f = '';
                if($row['forwards'] && is_array($row['forwards']))
                {
                    foreach($row['forwards'] as $fd)
                    {
                        $f .= ($stats_clan_info ? anchor('stats/' . $server_id . '/clan_info/' . $fd['clan_id'], $fd['clan_name']) : $fd['clan_name']) . ', ';
                    }
                    
                    $f = substr($f, 0, -2);
                }
                else
                {
                    $f = '<span class="label label-info">' . lang('Нет') . '</span>';
                }
                echo $f;
                ?> <br />
                <?php echo lang('Защитники') ?>:
                <?php
                $f = '';
                if($row['defenders'] && is_array($row['defenders']))
                {
                    foreach($row['defenders'] as $fd)
                    {
                        $f .= ($stats_clan_info ? anchor('stats/' . $server_id . '/clan_info/' . $fd['clan_id'], $fd['clan_name']) : $fd['clan_name']);
                    }
                }
                else
                {
                    $f = '<span class="label label-info">' . lang('Нет') . '</span>';
                }
                echo $f;
                ?> <br />
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>