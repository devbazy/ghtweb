<div class="content-box left">
    <div class="content-box-header">
        <h3><?php echo lang('Редактирование аккаунта') ?>: <?php echo $server_name ?></h3>
    </div>
    <div class="content-box-content">
        
        <?php if($content) { ?>
            <?php echo form_open() ?>
                <ul class="row">
                    <?php foreach($content as $key => $val) { ?>
                        <li>
                            <label for="<?php echo $key ?>"><?php echo $key ?>:</label>
                            <input type="text" name="<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $val ?>" class="text-input" />
                        </li>
                    <?php } ?>
                </ul>
                <input type="submit" value="<?php echo lang('Сохранить') ?>" name="submit" class="button" />
            <?php echo form_close() ?>
        <?php } else { ?>
            <?php echo lang('Данных нет') ?>
        <?php } ?>
        
    </div>
</div>