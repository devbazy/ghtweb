<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Личный кабинет'), 'url' => 'cabinet'),
        array('name' => lang('Привязка игрового аккаунта к Мастер Аккаунту'), 'current' => true),
    ),
)) ?>


<?php echo $message ?>

<?php if($this->_data['server_list']) { ?>
    <?php echo form_open('', 'class="form-horizontal"') ?>
    
        <fieldset>
            <?php if(count($server_list) > 1) { ?>
                <div class="control-group<?php echo (form_error('server_id') ? ' error' : '') ?>">
                    <label class="control-label"><?php echo lang('Выберите сервер') ?></label>
                    <div class="controls">
                        <?php echo form_dropdown('server_id', $server_list, set_value('server_id'), 'style="width: 280px;"') ?>
                        <?php if(form_error('server_id')) { ?>
                            <p class="help-block"><?php echo form_error('server_id') ?></p>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <div class="control-group<?php echo (form_error('login') ? ' error' : '') ?>">
                <label for="login" class="control-label"><?php echo lang('Логин') ?></label>
                <div class="controls">
                    <input type="text" name="login" id="login" value="<?php echo set_value('login') ?>" class="input-xlarge" placeholder="<?php echo lang('Введите Логин') ?>" />
                    <?php if(form_error('login')) { ?>
                        <p class="help-block"><?php echo form_error('login') ?></p>
                    <?php } ?>
                </div>
            </div>
            <div class="control-group<?php echo (form_error('password') ? ' error' : '') ?>">
                <label for="password" class="control-label"><?php echo lang('Пароль') ?></label>
                <div class="controls">
                    <input type="password" name="password" id="password" value="" class="input-xlarge" placeholder="<?php echo lang('Введите Пароль') ?>" />
                    <?php if(form_error('password')) { ?>
                        <p class="help-block"><?php echo form_error('password') ?></p>
                    <?php } ?>
                </div>
            </div>
            <button class="btn btn-primary" style="margin: 0 0 0 165px;" type="submit" name="submit"><?php echo lang('Привязать игровой аккаунт к Мастер Аккаунту') ?></button>
        </fieldset> 

    <?php echo form_close() ?>
<?php } ?>