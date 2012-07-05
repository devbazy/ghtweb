<div class="page-header">
    <h1>Пользователи сайта <small>добавление</small></h1>
</div>

<?php echo $message ?>

<?php echo form_open('', 'class="form-horizontal"') ?>
    <fieldset>
        <div class="control-group<?php echo (form_error('login') ? ' error' : '') ?>">
            <label for="login" class="control-label">Логин</label>
            <div class="controls">
                <input type="text" name="login" id="login" value="<?php echo set_value('login') ?>" class="span10" placeholder="Введите Логин" />
                <?php if(form_error('login')) { ?>
                    <p class="help-block"><?php echo form_error('login') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('password') ? ' error' : '') ?>">
            <label for="password" class="control-label">Пароль</label>
            <div class="controls">
                <input type="text" name="password" id="password" value="<?php echo set_value('password') ?>" class="span10" placeholder="Введите Пароль" />
                <?php if(form_error('password')) { ?>
                    <p class="help-block"><?php echo form_error('password') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('email') ? ' error' : '') ?>">
            <label for="email" class="control-label">Email</label>
            <div class="controls">
                <input type="text" name="email" id="email" value="<?php echo set_value('email') ?>" class="span10" placeholder="Введите Email" />
                <?php if(form_error('email')) { ?>
                    <p class="help-block"><?php echo form_error('email') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('money') ? ' error' : '') ?>">
            <label for="money" class="control-label">Денег</label>
            <div class="controls">
                <input type="text" name="money" id="money" value="<?php echo set_value('money') ?>" class="span10" placeholder="Введите сколько дать денег" />
                <?php if(form_error('money')) { ?>
                    <p class="help-block"><?php echo form_error('money') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('group') ? ' error' : '') ?>">
            <label class="control-label">Группа</label>
            <div class="controls">
                <?php echo form_dropdown('group', $groups, 2) ?>
                <?php if(form_error('group')) { ?>
                    <p class="help-block"><?php echo form_error('group') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit" name="submit">Создать</button>
            <a href="/backend/users/" class="btn">Отмена</a>
        </div>
    </fieldset>
<?php echo form_close() ?>