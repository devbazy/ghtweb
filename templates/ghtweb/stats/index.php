<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Статистика'), 'current' => true),
    ),
)) ?>

<?php echo $message ?>

<?php if($server_list) { ?>
    <div class="server-list-block1">
        <p class="left" style="margin-right: 10px;"><?php echo lang('Выберите сервер') ?>:</p>
        <ul class="unstyled left">
            <?php
            $gsu = ((int) get_segment_uri(2) > 0 ? (int) get_segment_uri(2) : key($server_list));
            
            foreach($server_list as $sid => $server_name) { ?>
                <li <?php echo ($gsu == $sid ? 'class="active"' : '') ?>><?php echo anchor('stats/' . $sid, $server_name) ?></li>
            <?php } ?>
            
        </ul>
    </div>
    <div class="clear"></div>
    <div class="server-list-block1">
        <ul class="unstyled left">
            <?php
            $mod = (get_segment_uri(3) && in_array(get_segment_uri(3), $types_stats) ? get_segment_uri(3) : $default_stats);
            foreach($types_stats as $stats => $allow) { ?>
                <?php if($allow) { ?>
                    <li <?php echo ($mod == $stats ? 'class="active"' : '') ?>><?php echo anchor('stats/' . $gsu . '/' . $stats, lang($stats)) ?></li>
                <?php } ?>
            <?php } ?>
            
        </ul>
    </div>
    <div class="clear"></div>
    <?php echo $content ?>
<?php } ?>