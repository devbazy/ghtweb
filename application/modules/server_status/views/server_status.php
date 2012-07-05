<?php if($content) { ?>
    <table class="table">
        <?php foreach($content as $server_id => $row) { ?>
            <tr>
                <td width="61%"><?php echo $row['name'] ?></td>
                <td width="14%"><img src="/resources/images/status/<?php echo $row['status'] ?>.png" alt="" title="<?php echo $row['status'] ?>" width="16" height="16" /></td>
                <td width="25%"><?php echo $row['online'] ?></td>
            </tr>
        <?php } ?>
        <?php if(count($content) > 1) { ?>
            <tr>
                <td colspan="2"><?php echo lang('Общий онлайн') ?></td>
                <td><?php echo $total_online ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <?php echo lang('Сервер не найден') ?>
<?php } ?>