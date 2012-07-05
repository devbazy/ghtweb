<div class="page-header">
    <h1>Настройки <small><?php echo $group_name['title'] ?></small> <span class="badge badge-info"><?php echo count($content) ?></span></h1>
</div>

<?php echo $message ?>

<?php if($content) { ?>
    <?php echo form_open('', 'class="form-horizontal"') ?>
        <fieldset>
            <?php foreach($content as $row) { ?>
                
                <div class="control-group<?php echo (form_error($row['type']) ? ' error' : '') ?>">
                    <label for="<?php echo $row['key'] ?>" class="control-label"><?php echo $row['name'] ?></label>
                    <div class="controls">
                        
                        <?php
                        $type = 'form_' . $row['type'];
                        
                        switch($row['type'])
                        {
                            case 'input':
                                $res = form_input($row['key'], $row['value'], 'class="span10" id="' . $row['key'] . '"');
                                break;
                            case 'textarea':
                                $res = form_textarea($row['key'], $row['value'], 'style="width: 778px;" cols="30" rows="7"');
                                break;
                            case 'dropdown':
                                $res = form_dropdown($row['key'], $row['param'], $row['value']);
                                break;
                            case 'radio':
                            
                                $res = '
                                <input type="hidden" name="' . $row['key'] . '" value="' . $row['value'] . '" />
                                <div data-toggle="buttons-radio" class="btn-group">
                                    <button class="btn btn-success ' . ($row['value'] == 1 ? 'active' : '') . '" type="button" data-value="1">Вкл</button>
                                    <button class="btn btn-danger ' . ($row['value'] == 0 ? 'active' : '') . '" type="button" data-value="0">Выкл</button>
                                </div>';
                            
                                /*if($row['key'] == 'forgotten_password_type')
                                {
                                    $res = yes_no($row['key'], $row['value'], array('email', lang('сайт')));
                                }
                                else
                                {
                                    $res = yes_no($row['key'], $row['value']);
                                }*/
                                break;
                        }

                        echo $res;      
                        ?>
                        
                        <?php if($row['description']) { ?>
                            <p class="help-block"><?php echo $row['description'] ?></p>
                        <?php } ?>
                        
                        <?php if(form_error($row['type'])) { ?>
                            <p class="help-block"><?php echo form_error($row['type']) ?></p>
                        <?php } ?>
                    </div>
                </div>
                
            <?php } ?>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit" name="submit">Сохранить</button>
                <a href="/backend/" class="btn">Отмена</a>
            </div>
        </fieldset>
    <?php echo form_close() ?>
<?php } else { ?>
    <?php echo Message::info('Настроек нет') ?>
<?php } ?>