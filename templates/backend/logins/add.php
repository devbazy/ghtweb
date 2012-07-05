<div class="page-header">
    <h1>Логин сервера <small>добавление</small></h1>
</div>

<?php echo $message ?>

<?php echo form_open('', 'class="form-horizontal"') ?>
    <fieldset>
        
        <legend>Общие настройки</legend>
        
        <div class="control-group<?php echo (form_error('name') ? ' error' : '') ?>">
            <label for="name" class="control-label">Название</label>
            <div class="controls">
                <input type="text" name="name" id="name" value="<?php echo set_value('name') ?>" class="span10" placeholder="Введите название" />
                <?php if(form_error('name')) { ?>
                    <p class="help-block"><?php echo form_error('name') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('ip') ? ' error' : '') ?>">
            <label for="ip" class="control-label">IP</label>
            <div class="controls">
                <input type="text" name="ip" id="ip" value="<?php echo set_value('ip') ?>" class="span10" placeholder="Введите IP" />
                <?php if(form_error('ip')) { ?>
                    <p class="help-block"><?php echo form_error('ip') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('port') ? ' error' : '') ?>">
            <label for="port" class="control-label">Порт</label>
            <div class="controls">
                <input type="text" name="port" id="port" value="<?php echo set_value('port') ?>" class="span10" placeholder="Введите Порт" />
                <?php if(form_error('port')) { ?>
                    <p class="help-block"><?php echo form_error('port') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('version') ? ' error' : '') ?>">
            <label for="version" class="control-label">Версия сервера</label>
            <div class="controls">
                <?php echo form_dropdown('version', array_combine($this->config->item('types_of_servers', 'lineage'), $this->config->item('types_of_servers', 'lineage')), set_value('version')) ?>
                <?php if(form_error('version')) { ?>
                    <p class="help-block"><?php echo form_error('version') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('allow') ? ' error' : '') ?>">
            <label for="allow" class="control-label">Статус</label>
            <div class="controls">
                <input type="hidden" name="allow" value="<?php echo set_value('allow', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('allow', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('allow', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('allow')) { ?>
                    <p class="help-block"><?php echo form_error('allow') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('password_type') ? ' error' : '') ?>">
            <label for="password_type" class="control-label">Тип пароля</label>
            <div class="controls">
                <?php echo form_dropdown('password_type', array_combine($this->config->item('password_type', 'lineage'), $this->config->item('password_type', 'lineage')), set_value('password_type')) ?>
                <p class="help-block">Выберите тип шифрования пароля для аккаунтов</p>
                <?php if(form_error('password_type')) { ?>
                    <p class="help-block"><?php echo form_error('password_type') ?></p>
                <?php } ?>
            </div>
        </div>
        
        <legend>MYSQL настройки</legend>
        
        <div class="control-group<?php echo (form_error('db_host') ? ' error' : '') ?>">
            <label for="db_host" class="control-label">MYSQL хост</label>
            <div class="controls">
                <input type="text" name="db_host" id="db_host" value="<?php echo set_value('db_host') ?>" class="span10" placeholder="Введите MYSQL хост" />
                <?php if(form_error('db_host')) { ?>
                    <p class="help-block"><?php echo form_error('db_host') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('db_port') ? ' error' : '') ?>">
            <label for="db_port" class="control-label">MYSQL порт</label>
            <div class="controls">
                <input type="text" name="db_port" id="db_port" value="<?php echo set_value('db_port') ?>" class="span10" placeholder="Введите MYSQL порт" />
                <?php if(form_error('db_port')) { ?>
                    <p class="help-block"><?php echo form_error('db_port') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('db_user') ? ' error' : '') ?>">
            <label for="db_user" class="control-label">MYSQL пользователь</label>
            <div class="controls">
                <input type="text" name="db_user" id="db_user" value="<?php echo set_value('db_user') ?>" class="span10" placeholder="Введите MYSQL пользователя" />
                <?php if(form_error('db_user')) { ?>
                    <p class="help-block"><?php echo form_error('db_user') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('db_pass') ? ' error' : '') ?>">
            <label for="db_pass" class="control-label">MYSQL пароль</label>
            <div class="controls">
                <input type="text" name="db_pass" id="db_pass" value="<?php echo set_value('db_pass') ?>" class="span10" placeholder="Введите MYSQL пароль" />
                <?php if(form_error('db_pass')) { ?>
                    <p class="help-block"><?php echo form_error('db_pass') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('db_name') ? ' error' : '') ?>">
            <label for="db_name" class="control-label">MYSQL название БД</label>
            <div class="controls">
                <input type="text" name="db_name" id="db_name" value="<?php echo set_value('db_name') ?>" class="span10" placeholder="Введите MYSQL название БД" />
                <?php if(form_error('db_name')) { ?>
                    <p class="help-block"><?php echo form_error('db_name') ?></p>
                <?php } ?>
            </div>
        </div>
        
        <legend>TELNET настройки</legend>
        
        <div class="control-group<?php echo (form_error('telnet_host') ? ' error' : '') ?>">
            <label for="telnet_host" class="control-label">TELNET хост</label>
            <div class="controls">
                <input type="text" name="telnet_host" id="telnet_host" value="<?php echo set_value('telnet_host') ?>" class="span10" placeholder="Введите TELNET хост" />
                <?php if(form_error('telnet_host')) { ?>
                    <p class="help-block"><?php echo form_error('telnet_host') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('telnet_port') ? ' error' : '') ?>">
            <label for="telnet_port" class="control-label">TELNET порт</label>
            <div class="controls">
                <input type="text" name="telnet_port" id="telnet_port" value="<?php echo set_value('telnet_port') ?>" class="span10" placeholder="Введите TELNET порт" />
                <?php if(form_error('telnet_port')) { ?>
                    <p class="help-block"><?php echo form_error('telnet_port') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('telnet_pass') ? ' error' : '') ?>">
            <label for="telnet_pass" class="control-label">TELNET пароль</label>
            <div class="controls">
                <input type="text" name="telnet_pass" id="telnet_pass" value="<?php echo set_value('telnet_pass') ?>" class="span10" placeholder="Введите TELNET пароль" />
                <?php if(form_error('telnet_pass')) { ?>
                    <p class="help-block"><?php echo form_error('telnet_pass') ?></p>
                <?php } ?>
            </div>
        </div>
        
        <div class="form-actions">
            <button class="btn btn-primary" type="submit" name="submit">Добавить</button>
            <a href="/backend/logins/" class="btn">Отмена</a>
        </div>
    </fieldset>
<?php echo form_close() ?>