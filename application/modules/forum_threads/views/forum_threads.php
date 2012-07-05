<ul class="unstyled">
    <?php if($content) { ?>
        <?php foreach($content as $row) { ?>
            <li><a href="<?php echo $row['theme_link'] ?>" target="_blank"><?php echo character_limiter($row['title'], $forum_character_limit) ?></a></li>
        <?php } ?>
    <?php } else { ?>
        <li><?php echo lang('Данных нет') ?></li>
    <?php } ?>
</ul>