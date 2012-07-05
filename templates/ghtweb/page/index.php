<?php if($content) { ?>
    <div class="news-post">
        <div class="page-header">
            <h1><?php echo $content['title'] ?></h1>
        </div>
        <div class="text"><?php echo $content['text'] ?></div>
    </div>
<?php } else { ?>
    <?php echo Message::info('Страница не найдена') ?>
<?php } ?>