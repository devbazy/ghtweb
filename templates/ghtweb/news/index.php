<?php if($content) { ?>
    <?php foreach($content as $row) { ?>
        <div class="news-post">
            <h2><?php echo anchor('news/detail/' . $row['id'], $row['title']) ?></h2>
            <div class="text"><?php echo nl2br($row['description']) ?></div>
            <div class="news-post-status-bar">
                <span class="author"><b><?php echo lang('автор') ?></b>: <?php echo $row['author'] ?></span>, <span class="date"><b><?php echo lang('дата') ?></b>: <?php echo substr($row['date'], 0, -3) ?></span>
                <?php echo anchor('news/detail/' . $row['id'], lang('подробнее'), array('class' => 'more')) ?>
            </div>
        </div>
    <?php } ?>
    <?php echo $pagination ?>
<?php } else { ?>
    <?php echo Message::info('Новостей нет') ?>
<?php } ?>
