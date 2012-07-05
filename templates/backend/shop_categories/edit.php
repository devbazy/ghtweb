<div class="page-header">
    <h1>Разделы товаров <small>редактирование</small></h1>
</div>

<?php echo $message ?>

<?php echo form_open('', 'class="form-horizontal"') ?>
    <fieldset>
        <div class="control-group<?php echo (form_error('name') ? ' error' : '') ?>">
            <label for="name" class="control-label">Название</label>
            <div class="controls">
                <input type="text" name="name" id="name" value="<?php echo set_value('name', $content['name']) ?>" class="span10" placeholder="Введите Название раздела" />
                <?php if(form_error('name')) { ?>
                    <p class="help-block"><?php echo form_error('name') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('allow') ? ' error' : '') ?>">
            <label for="allow" class="control-label">Статус</label>
            <div class="controls">
                <input type="hidden" name="allow" value="<?php echo set_value('allow', $content['allow']) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('allow', $content['allow']) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('allow', $content['allow']) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('allow')) { ?>
                    <p class="help-block"><?php echo form_error('allow') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit" name="submit">Сохранить</button>
            <a href="/backend/shop_categories/" class="btn">Отмена</a>
        </div>
    </fieldset>
<?php echo form_close() ?>