<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Личный кабинет'), 'url' => 'cabinet'),
        array('name' => lang('Защита аккаунта'), 'current' => true),
    ),
)) ?>


<?php echo $message ?>

<?php echo form_open('', 'class="form-horizontal"') ?>
    
    <div class="alert alert-info">
        <button class="close" data-dismiss="alert">×</button>
        <?php echo lang('Пустое поле отключает привязку') ?><br />
        <?php echo lang('Ваш текущий IP') ?> <b><?php echo $this->input->ip_address() ?></b>
    </div>
    
    <fieldset>
        <div class="control-group<?php echo (form_error('protected_ip') ? ' error' : '') ?>">
            <label for="protected_ip" class="control-label"><?php echo lang('IP адрес') ?></label>
            <div class="controls">
                <input type="text" name="protected_ip" id="protected_ip" value="<?php echo set_value('protected_ip', $this->auth->get('protected_ip')) ?>" class="input-xlarge" placeholder="<?php echo lang('Введите IP адрес') ?>" />
                <?php if(form_error('protected_ip')) { ?>
                    <p class="help-block"><?php echo form_error('protected_ip') ?></p>
                <?php } ?>
            </div>
        </div>
        <button class="btn btn-primary" style="margin: 0 0 0 165px;" type="submit" name="submit"><?php echo lang('Изменить') ?></button>
    </fieldset>

<?php echo form_close() ?>