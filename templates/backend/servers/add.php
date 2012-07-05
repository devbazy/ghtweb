<div class="page-header">
    <h1>Игровые сервера <small>добавление</small></h1>
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
        <div class="control-group<?php echo (form_error('login_id') ? ' error' : '') ?>">
            <label for="login_id" class="control-label">Логин</label>
            <div class="controls">
                <?php echo form_dropdown('login_id', $login_list, set_value('login_id')) ?>
                <?php if(form_error('login_id')) { ?>
                    <p class="help-block"><?php echo form_error('login_id') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('version') ? ' error' : '') ?>">
            <label for="version" class="control-label">Версия сервера</label>
            <div class="controls">
                <?php echo form_dropdown('version', array_combine($version_list, $version_list), set_value('version')) ?>
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
        <div class="control-group<?php echo (form_error('fake_online') ? ' error' : '') ?>">
            <label for="fake_online" class="control-label">Накрутка онлайна</label>
            <div class="controls">
                <input type="text" name="fake_online" id="fake_online" value="<?php echo set_value('fake_online', 0) ?>" class="span10" placeholder="Введите Накрутку онлайна" />
                <p class="help-block">ноль - отключает опцию</p>
                <?php if(form_error('fake_online')) { ?>
                    <p class="help-block"><?php echo form_error('fake_online') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('allow_teleport') ? ' error' : '') ?>">
            <label for="allow_teleport" class="control-label">Телепорт в город</label>
            <div class="controls">
                <input type="hidden" name="allow_teleport" value="<?php echo set_value('allow_teleport', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('allow_teleport', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('allow_teleport', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('allow_teleport')) { ?>
                    <p class="help-block"><?php echo form_error('allow_teleport') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('teleport_time') ? ' error' : '') ?>">
            <label for="teleport_time" class="control-label">Повтор телепорта</label>
            <div class="controls">
                <input type="text" name="teleport_time" id="teleport_time" value="<?php echo set_value('teleport_time', 30) ?>" class="span10" placeholder="Введите Время повторного телепорта в минутах" />
                <p class="help-block">Время повторного телепорта в минутах</p>
                <?php if(form_error('teleport_time')) { ?>
                    <p class="help-block"><?php echo form_error('teleport_time') ?></p>
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
       
        <legend>Статистика</legend>
        
        <div class="control-group<?php echo (form_error('stats_allow') ? ' error' : '') ?>">
            <label for="stats_allow" class="control-label">Статистика</label>
            <div class="controls">
                <input type="hidden" name="stats_allow" value="<?php echo set_value('stats_allow', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('stats_allow', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('stats_allow', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('stats_allow')) { ?>
                    <p class="help-block"><?php echo form_error('stats_allow') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_cache_time') ? ' error' : '') ?>">
            <label for="stats_cache_time" class="control-label">Время кэширования</label>
            <div class="controls">
                <input type="text" name="stats_cache_time" id="stats_cache_time" value="<?php echo set_value('stats_cache_time', 15) ?>" class="span10" placeholder="Введите Время кэширования в минутах" />
                <?php if(form_error('stats_cache_time')) { ?>
                    <p class="help-block"><?php echo form_error('stats_cache_time') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_count_results') ? ' error' : '') ?>">
            <label for="stats_count_results" class="control-label">Кол-во записей</label>
            <div class="controls">
                <input type="text" name="stats_count_results" id="stats_count_results" value="<?php echo set_value('stats_count_results', 20) ?>" class="span10" placeholder="Введите Кол-во записей на странице" />
                <?php if(form_error('stats_count_results')) { ?>
                    <p class="help-block"><?php echo form_error('stats_count_results') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_total') ? ' error' : '') ?>">
            <label for="stats_total" class="control-label">Общая</label>
            <div class="controls">
                <input type="hidden" name="stats_total" value="<?php echo set_value('stats_total', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('stats_total', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('stats_total', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('stats_total')) { ?>
                    <p class="help-block"><?php echo form_error('stats_total') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_pvp') ? ' error' : '') ?>">
            <label for="stats_pvp" class="control-label">ПВП</label>
            <div class="controls">
                <input type="hidden" name="stats_pvp" value="<?php echo set_value('stats_pvp', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('stats_pvp', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('stats_pvp', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('stats_pvp')) { ?>
                    <p class="help-block"><?php echo form_error('stats_pvp') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_pk') ? ' error' : '') ?>">
            <label for="stats_pk" class="control-label">ПК</label>
            <div class="controls">
                <input type="hidden" name="stats_pk" value="<?php echo set_value('stats_pk', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('stats_pk', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('stats_pk', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('stats_pk')) { ?>
                    <p class="help-block"><?php echo form_error('stats_pk') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_clans') ? ' error' : '') ?>">
            <label for="stats_clans" class="control-label">Кланы</label>
            <div class="controls">
                <input type="hidden" name="stats_clans" value="<?php echo set_value('stats_clans', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('stats_clans', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('stats_clans', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('stats_clans')) { ?>
                    <p class="help-block"><?php echo form_error('stats_clans') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_castles') ? ' error' : '') ?>">
            <label for="stats_castles" class="control-label">Замки</label>
            <div class="controls">
                <input type="hidden" name="stats_castles" value="<?php echo set_value('stats_castles', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('stats_castles', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('stats_castles', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('stats_castles')) { ?>
                    <p class="help-block"><?php echo form_error('stats_castles') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_online') ? ' error' : '') ?>">
            <label for="stats_online" class="control-label">В игре</label>
            <div class="controls">
                <input type="hidden" name="stats_online" value="<?php echo set_value('stats_online', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('stats_online', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('stats_online', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('stats_online')) { ?>
                    <p class="help-block"><?php echo form_error('stats_online') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_clan_info') ? ' error' : '') ?>">
            <label for="stats_clan_info" class="control-label">Информация о клане</label>
            <div class="controls">
                <input type="hidden" name="stats_clan_info" value="<?php echo set_value('stats_clan_info', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('stats_clan_info', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('stats_clan_info', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('stats_clan_info')) { ?>
                    <p class="help-block"><?php echo form_error('stats_clan_info') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_top') ? ' error' : '') ?>">
            <label for="stats_top" class="control-label">Топ игроки</label>
            <div class="controls">
                <input type="hidden" name="stats_top" value="<?php echo set_value('stats_top', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('stats_top', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('stats_top', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('stats_top')) { ?>
                    <p class="help-block"><?php echo form_error('stats_top') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('stats_rich') ? ' error' : '') ?>">
            <label for="stats_rich" class="control-label">Богачи</label>
            <div class="controls">
                <input type="hidden" name="stats_rich" value="<?php echo set_value('stats_rich', 1) ?>" />
                <div data-toggle="buttons-radio" class="btn-group">
                    <button class="btn btn-success <?php echo set_value('stats_rich', 1) == 1 ? 'active' : '' ?>" type="button" data-value="1">Вкл</button>
                    <button class="btn btn-danger <?php echo set_value('stats_rich', 1) == 0 ? 'active' : '' ?>" type="button" data-value="0">Выкл</button>
                </div>
                <?php if(form_error('stats_rich')) { ?>
                    <p class="help-block"><?php echo form_error('stats_rich') ?></p>
                <?php } ?>
            </div>
        </div>
        
        <legend>Рейты</legend>
        
        <div class="control-group<?php echo (form_error('exp') ? ' error' : '') ?>">
            <label for="exp" class="control-label">Exp</label>
            <div class="controls">
                <input type="text" name="exp" id="exp" value="<?php echo set_value('exp', 1) ?>" class="span10" placeholder="Введите Exp" />
                <?php if(form_error('exp')) { ?>
                    <p class="help-block"><?php echo form_error('exp') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('sp') ? ' error' : '') ?>">
            <label for="sp" class="control-label">Sp</label>
            <div class="controls">
                <input type="text" name="sp" id="sp" value="<?php echo set_value('sp', 1) ?>" class="span10" placeholder="Введите Sp" />
                <?php if(form_error('sp')) { ?>
                    <p class="help-block"><?php echo form_error('sp') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('adena') ? ' error' : '') ?>">
            <label for="adena" class="control-label">Adena</label>
            <div class="controls">
                <input type="text" name="adena" id="adena" value="<?php echo set_value('adena', 1) ?>" class="span10" placeholder="Введите Adena" />
                <?php if(form_error('adena')) { ?>
                    <p class="help-block"><?php echo form_error('adena') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('items') ? ' error' : '') ?>">
            <label for="items" class="control-label">Items</label>
            <div class="controls">
                <input type="text" name="items" id="items" value="<?php echo set_value('items', 1) ?>" class="span10" placeholder="Введите Items" />
                <?php if(form_error('items')) { ?>
                    <p class="help-block"><?php echo form_error('items') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('spoil') ? ' error' : '') ?>">
            <label for="spoil" class="control-label">Spoil</label>
            <div class="controls">
                <input type="text" name="spoil" id="spoil" value="<?php echo set_value('spoil', 1) ?>" class="span10" placeholder="Введите Spoil" />
                <?php if(form_error('spoil')) { ?>
                    <p class="help-block"><?php echo form_error('spoil') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('q_drop') ? ' error' : '') ?>">
            <label for="q_drop" class="control-label">Quest drop</label>
            <div class="controls">
                <input type="text" name="q_drop" id="q_drop" value="<?php echo set_value('q_drop', 1) ?>" class="span10" placeholder="Введите Quest drop" />
                <?php if(form_error('q_drop')) { ?>
                    <p class="help-block"><?php echo form_error('q_drop') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('q_reward') ? ' error' : '') ?>">
            <label for="q_reward" class="control-label">Quest reward</label>
            <div class="controls">
                <input type="text" name="q_reward" id="q_reward" value="<?php echo set_value('q_reward', 1) ?>" class="span10" placeholder="Введите Quest reward" />
                <?php if(form_error('q_reward')) { ?>
                    <p class="help-block"><?php echo form_error('q_reward') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('rb') ? ' error' : '') ?>">
            <label for="rb" class="control-label">Raid bos drop</label>
            <div class="controls">
                <input type="text" name="rb" id="rb" value="<?php echo set_value('rb', 1) ?>" class="span10" placeholder="Введите Raid bos drop" />
                <?php if(form_error('rb')) { ?>
                    <p class="help-block"><?php echo form_error('rb') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('erb') ? ' error' : '') ?>">
            <label for="erb" class="control-label">Epic raid bos drop</label>
            <div class="controls">
                <input type="text" name="erb" id="erb" value="<?php echo set_value('erb', 1) ?>" class="span10" placeholder="Введите Epic raid bos drop" />
                <?php if(form_error('erb')) { ?>
                    <p class="help-block"><?php echo form_error('erb') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit" name="submit">Добавить</button>
            <a href="/backend/servers/" class="btn">Отмена</a>
        </div>
    </fieldset>
<?php echo form_close() ?>