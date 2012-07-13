<ul class="unstyled">
    <?php if($content) { ?>
        <?php foreach($content as $row) { ?>
            <li>
                <span class="label label-warning"><?php echo $row['char_name'] ?></span> <span class="label"><?php echo get_class_name_by_id($row['class_id']) ?></span> <span class="label label-info"><?php echo $row['pkkills'] ?></span>
            </li>
        <?php } ?>
    <?php } else { ?>
        <li><?php echo lang('Данных нет') ?></li>
    <?php } ?>
</ul>