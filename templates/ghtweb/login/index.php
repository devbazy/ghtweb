<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Авторизация'), 'current' => true),
    ),
)) ?>


<?php echo $message ?>

<?php echo form_open('', 'class="form-horizontal"') ?>
    <fieldset>
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
                <input type="password" name="password" id="password" class="input-xlarge" placeholder="<?php echo lang('Введите Пароль') ?>" />
                <?php if(form_error('password')) { ?>
                    <p class="help-block"><?php echo form_error('password') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('captcha') ? ' error' : '') ?>">
            <div class="captcha" style="margin: -10px 0 8px 165px;"><?php echo $captcha ?></div>
            <label for="captcha" class="control-label"><?php echo lang('Код с картинки') ?></label>
            <div class="controls">
                <input type="text" name="captcha" id="captcha" class="input-xlarge" placeholder="<?php echo lang('Введите Код с картинки') ?>" />
                <?php if(form_error('captcha')) { ?>
                    <p class="help-block"><?php echo form_error('captcha') ?></p>
                <?php } ?>
            </div>
        </div>
        <button class="btn btn-primary" style="margin: 0 0 0 165px;" type="submit" name="submit"><?php echo lang('Вход') ?></button>
        <?php echo anchor('forgotten_password', lang('Забыли пароль?'), array('class' => 'btn')) ?> 
    </fieldset>
<?php echo form_close() ?>

