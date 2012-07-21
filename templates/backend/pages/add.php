<div class="page-header">
    <h1>Страницы <small>добавление</small></h1>
</div>

<?php echo $message ?>

<?php echo form_open('', 'class="form-horizontal"') ?>
    <fieldset>
        <div class="control-group<?php echo (form_error('page') ? ' error' : '') ?>">
            <label for="page" class="control-label">Ссылка на страницу</label>
            <div class="controls">
                <input type="text" name="page" id="page" value="<?php echo set_value('page') ?>" class="span10" placeholder="Введите Ссылку латинскими буквами" />
                <p class="help-block">Пример: donat</p>
                <?php if(form_error('page')) { ?>
                    <p class="help-block"><?php echo form_error('page') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('title') ? ' error' : '') ?>">
            <label for="title" class="control-label">Название</label>
            <div class="controls">
                <input type="text" name="title" id="title" value="<?php echo set_value('title') ?>" class="span10" placeholder="Введите Название" />
                <?php if(form_error('title')) { ?>
                    <p class="help-block"><?php echo form_error('title') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('text') ? ' error' : '') ?>">
            <label for="text" class="control-label">Текст</label>
            <div class="controls">
                <textarea name="text" id="text" style="width: 780px; height: 400px;"><?php echo set_value('text') ?></textarea>
                <?php if(form_error('text')) { ?>
                    <p class="help-block"><?php echo form_error('text') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('seo_title') ? ' error' : '') ?>">
            <label for="seo_title" class="control-label">СЕО титул</label>
            <div class="controls">
                <input type="text" name="seo_title" id="seo_title" value="<?php echo set_value('seo_title') ?>" class="span10" placeholder="Введите СЕО титул" />
                <p class="help-block">Используется в &lt;title&gt;</p>
                <?php if(form_error('seo_title')) { ?>
                    <p class="help-block"><?php echo form_error('seo_title') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('seo_keywords') ? ' error' : '') ?>">
            <label for="seo_keywords" class="control-label">СЕО ключевые слова</label>
            <div class="controls">
                <input type="text" name="seo_keywords" id="seo_keywords" value="<?php echo set_value('seo_keywords') ?>" class="span10" placeholder="Введите СЕО ключевые слова" />
                <p class="help-block">Используется в &lt;keywords&gt;</p>
                <?php if(form_error('seo_keywords')) { ?>
                    <p class="help-block"><?php echo form_error('seo_keywords') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('seo_description') ? ' error' : '') ?>">
            <label for="seo_description" class="control-label">СЕО описание</label>
            <div class="controls">
                <input type="text" name="seo_description" id="seo_description" value="<?php echo set_value('seo_description') ?>" class="span10" placeholder="Введите СЕО описание" />
                <p class="help-block">Используется в &lt;description&gt;</p>
                <?php if(form_error('seo_description')) { ?>
                    <p class="help-block"><?php echo form_error('seo_description') ?></p>
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
        <div class="control-group<?php echo (form_error('lang') ? ' error' : '') ?>">
            <label for="lang" class="control-label">Язык</label>
            <div class="controls">
                <?php echo form_dropdown('lang', $this->config->item('languages'), set_value('lang')) ?>
                <?php if(form_error('lang')) { ?>
                    <p class="help-block"><?php echo form_error('lang') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('in_menu') ? ' error' : '') ?>">
            <label for="in_menu" class="control-label">Добавить в меню</label>
            <div class="controls">
                <input type="hidden" name="in_menu" value="<?php echo set_value('in_menu', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('in_menu', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Да</button>
                    <button class="btn btn-danger <?php echo set_value('in_menu', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Нет</button>
                </div>
                <p class="help-block">Будет добавлена в массив со страницами которые выводятся на сайте</p>
                <?php if(form_error('in_menu')) { ?>
                    <p class="help-block"><?php echo form_error('in_menu') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit" name="submit">Добавить</button>
            <a href="/backend/pages/" class="btn">Отмена</a>
        </div>
    </fieldset>
<?php echo form_close() ?>


<?php echo get_wysiwyg($this->config->item('wysiwyg_editor_type'), array('text')) ?>