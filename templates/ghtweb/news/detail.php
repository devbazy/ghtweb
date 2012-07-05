<?php if($content) { ?>
    <div class="news-post">
        <h2><?php echo anchor('news', lang('Новости')) ?> &rarr; <?php echo $content['title'] ?></h2>
        <div class="text"><?php echo $content['text'] ?></div>
        <div class="news-post-status-bar">
            <span class="author"><b><?php echo lang('автор') ?></b>: <?php echo $content['author'] ?></span>, <span class="date"><b><?php echo lang('дата') ?></b>: <?php echo substr($content['date'], 0, -3) ?></span>
        </div>        
    </div><?php } else { ?>
    <?php echo Message::info('Новость не найдена') ?>
<?php } ?>
