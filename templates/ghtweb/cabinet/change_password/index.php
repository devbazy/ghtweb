<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Личный кабинет'), 'url' => 'cabinet'),
        array('name' => lang('Смена пароля'), 'current' => true),
    ),
)) ?>


<?php echo $message ?>

<?php echo form_open('', 'class="form-horizontal"') ?>
    
    <fieldset>
        <div class="control-group<?php echo (form_error('old_password') ? ' error' : '') ?>">
            <label for="old_password" class="control-label"><?php echo lang('Старый пароль') ?></label>
            <div class="controls">
                <input type="password" name="old_password" id="old_password" value="<?php echo set_value('old_password') ?>" class="input-xlarge" placeholder="<?php echo lang('Введите Старый пароль') ?>" />
                <?php if(form_error('old_password')) { ?>
                    <p class="help-block"><?php echo form_error('old_password') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('new_password') ? ' error' : '') ?>">
            <label for="new_password" class="control-label"><?php echo lang('Новый пароль') ?></label>
            <div class="controls">
                <input type="password" name="new_password" id="new_password" value="<?php echo set_value('new_password') ?>" class="input-xlarge" placeholder="<?php echo lang('Введите Новый пароль') ?>" />
                <?php if(form_error('new_password')) { ?>
                    <p class="help-block"><?php echo form_error('new_password') ?></p>
                <?php } ?>
            </div>
        </div>
        <button class="btn btn-primary" style="margin: 0 0 0 165px;" type="submit" name="submit"><?php echo lang('Изменить') ?></button>
    </fieldset>    

<?php echo form_close() ?>