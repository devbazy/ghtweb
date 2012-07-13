<div class="page-header">
    <h1>Магазин <small>добавление товара</small></h1>
</div>

<script type="text/javascript" src="/resources/libs/jqueryUI/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/resources/libs/jqueryUI/js/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" type="text/css" href="/resources/libs/jqueryUI/css/smoothness/jquery-ui-1.8.16.custom.css" media="all" />
<link rel="stylesheet" type="text/css" href="/templates/<?php echo TPL_DIR ?>/css/ui_autocomplite.css" media="all" />


<script type="text/javascript">
$(function(){
    
    $('#date_start, #date_stop').datetimepicker({
        timeFormat: 'hh:mm:ss',
        showSecond: true,
        dateFormat: 'yy-mm-dd'
    });
    
    $('input#item_name').autocomplete({
        minLength: 3,
        source: function(event, ui){
            
            var params = {
                value: event.term,
                csrf: $('input:hidden[name=csrf]').val()
            };
            
            $.post('/backend/shop/search_item_by_name',params,function(data){
                
                ui($.map(data.message, function(item){
                  return{
                    label: item.name + ' [' + item.item_id + ']',
                    value: item.item_id,
                    original_name: item.name
                  }
                }));
                
            },'json').error(function(e){
                console.log('error');
            });
        },
        select: function(event, ui){
            console.log(ui);
            $('input[name=item_name]').val(ui.item.original_name);
            $('input[name=item_id]').val(ui.item.value);
            return false;
        },
        focus: function(event, ui){
            $('input[name=item_name]').val(ui.item.original_name);
            return false;
        }
    });
})
</script>

<?php echo $message ?>

<?php echo form_open('', 'class="form-horizontal"') ?>
    <fieldset>
        <div class="control-group<?php echo (form_error('item_name') ? ' error' : '') ?>">
            <label for="item_name" class="control-label">Название предмета</label>
            <div class="controls">
                <input type="hidden" name="item_id" value="<?php echo set_value('item_id') ?>" />
                <input type="text" name="item_name" id="item_name" value="<?php echo set_value('item_name') ?>" class="span10" placeholder="Введите название предмета" />
                <p class="help-block">Начните вводить название, если в базе найдутся совпадения то они появятся</p>
                <?php if(form_error('item_name')) { ?>
                    <p class="help-block"><?php echo form_error('item_name') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('price') ? ' error' : '') ?>">
            <label for="price" class="control-label">Цена</label>
            <div class="controls">
                <input type="text" name="price" id="price" value="<?php echo set_value('price') ?>" class="span10" placeholder="Введите Цену" />
                <?php if(form_error('price')) { ?>
                    <p class="help-block"><?php echo form_error('price') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('count') ? ' error' : '') ?>">
            <label for="count" class="control-label">Кол-во</label>
            <div class="controls">
                <input type="text" name="count" id="count" value="<?php echo set_value('count') ?>" class="span10" placeholder="Введите Кол-во единиц которые входят в цену выше" />
                <?php if(form_error('count')) { ?>
                    <p class="help-block"><?php echo form_error('count') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('enchant_level') ? ' error' : '') ?>">
            <label for="enchant_level" class="control-label">Заточка</label>
            <div class="controls">
                <input type="text" name="enchant_level" id="enchant_level" value="<?php echo set_value('enchant_level') ?>" class="span10" placeholder="Введите Уровень заточки" />
                <?php if(form_error('enchant_level')) { ?>
                    <p class="help-block"><?php echo form_error('enchant_level') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('date_start') ? ' error' : '') ?>">
            <label for="date_start" class="control-label">Дата начала продаж</label>
            <div class="controls">
                <input type="text" name="date_start" id="date_start" value="<?php echo set_value('date_start') ?>" class="span10" placeholder="Введите Дату начала продаж" />
                <p class="help-block">Формат ввода: Y-m-d H:i:s, к примеру 2012-03-10 22:47:10</p>
                <?php if(form_error('date_start')) { ?>
                    <p class="help-block"><?php echo form_error('date_start') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('date_stop') ? ' error' : '') ?>">
            <label for="date_stop" class="control-label">Дата окончания продаж</label>
            <div class="controls">
                <input type="text" name="date_stop" id="date_stop" value="<?php echo set_value('date_stop') ?>" class="span10" placeholder="Введите Дату окончания продаж" />
                <p class="help-block">Формат ввода: Y-m-d H:i:s, к примеру 2012-03-10 22:47:10</p>
                <?php if(form_error('date_stop')) { ?>
                    <p class="help-block"><?php echo form_error('date_stop') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('description') ? ' error' : '') ?>">
            <label for="description" class="control-label">Описание</label>
            <div class="controls">
                <textarea name="description" id="description" cols="30" rows="3" class="span10" placeholder="Введите Описание товара"><?php echo set_value('description') ?></textarea>
                <?php if(form_error('description')) { ?>
                    <p class="help-block"><?php echo form_error('description') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('category_id') ? ' error' : '') ?>">
            <label for="category_id" class="control-label">Категория</label>
            <div class="controls">
                <?php echo form_dropdown('category_id', $categories, set_value('category_id')) ?>
                <?php if(form_error('category_id')) { ?>
                    <p class="help-block"><?php echo form_error('category_id') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('item_type') ? ' error' : '') ?>">
            <label for="item_type" class="control-label">Тип предмета</label>
            <div class="controls">
                <?php echo form_dropdown('item_type', array_combine($item_type, $item_type), set_value('item_type')) ?>
                <p class="help-block"><b>stock</b> - добавится к существующему, <b>no_stock</b> - добавиться отдельно</p>
                <?php if(form_error('item_type')) { ?>
                    <p class="help-block"><?php echo form_error('item_type') ?></p>
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
        <div class="form-actions">
            <button class="btn btn-primary" type="submit" name="submit">Добавить</button>
            <a href="/backend/shop/" class="btn">Отмена</a>
        </div>
    </fieldset>
<?php echo form_close() ?>