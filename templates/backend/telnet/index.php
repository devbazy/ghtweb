<div class="page-header">
    <h1>Telnet <small>управление</small></h1>
</div>

<?php echo $message ?>

<?php echo Message::info('
    <b>Анонс:</b> announce text<br />
    <b>Личное сообщение:</b> pm Admin text<br />
    <b>Выкинуть игрока:</b> kick Admin<br />
    <b>Рестарт:</b> restart 3600<br />
    <b>Выключить:</b> restart 3600<br />
') ?>

<?php echo form_open('', 'class="form-horizontal"') ?>
    <fieldset>
        
        <?php if(count($server_list) > 1) { ?>
            <div class="control-group<?php echo (form_error('server_id') ? ' error' : '') ?>">
                <label class="control-label"><?php echo lang('Выберите сервер') ?></label>
                <div class="controls">
                    <?php echo form_dropdown('server_id', $server_list, set_value('server_id')) ?>
                    <?php if(form_error('server_id')) { ?>
                        <p class="help-block"><?php echo form_error('server_id') ?></p>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        
        <div class="control-group<?php echo (form_error('command') ? ' error' : '') ?>">
            <label for="command" class="control-label">Команда</label>
            <div class="controls">
                <input type="text" name="command" id="command" value="<?php echo set_value('command') ?>" class="span10" placeholder="Введите команду для отправки" />
                <?php if(form_error('command')) { ?>
                    <p class="help-block"><?php echo form_error('command') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit" name="submit">Отправить</button>
            <a href="/backend/" class="btn">Отмена</a>
        </div>
    </fieldset>
<?php echo form_close() ?>