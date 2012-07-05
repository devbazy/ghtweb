<div class="page-header">
    <h1>Пользователи сайта <small>просмотр склада</small> <span class="badge badge-info"><?php echo $count ?></span> <span class="label label-info"><?php echo $user_data['login'] ?></span></h1>
</div>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<script type="text/javascript" src="/resources/libs/jqueryUI/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/resources/libs/jqueryUI/js/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" type="text/css" href="/resources/libs/jqueryUI/css/smoothness/jquery-ui-1.8.16.custom.css" media="all" />
<link rel="stylesheet" type="text/css" href="/templates/<?php echo TPL_DIR ?>/css/ui_autocomplite.css" media="all" />

<script type="text/javascript">
$(function(){
    
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

<?php echo form_open('backend/users/add_warehouse_item', 'class="form-horizontal" style="margin: 0;"') ?>
    <fieldset>
        <div class="control-group<?php echo (form_error('title') ? ' error' : '') ?>">
                <input type="hidden" name="item_id" />
                <input type="hidden" name="user_id" value="<?php echo (int) get_segment_uri(4) ?>" />
                <input type="text" name="item_name" id="item_name" class="" placeholder="Название предмета" />
                <input type="text" name="count" class="span2" placeholder="Кол-во" />
                <button class="btn btn-primary" type="submit" name="submit">Добавить предмет</button>
        </div>
    </fieldset>
<?php echo form_close() ?>

<table class="table table-striped table-bordered">
    <tr>
        <th width="5%"></th>
        <th width="58%">Название</th>
        <th width="12%">Находится</th>
        <th width="10%">Кол-во</th>
        <th width="10%">Цена покупки</th>
        <th width="6%"></th>
    </tr>
    <?php if($content) { ?>
        <?php foreach($content as $row) { ?>
            <tr>
                <td><img src="<?php echo (file_exists(FCPATH . 'resources/images/items/' . $row['item_id'] . '.gif') ? '/resources/images/items/' . $row['item_id'] . '.gif' : '/resources/images/items/blank.gif') ?>" alt="" title="<?php echo $row['name'] ?>" /></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo ($row['moved_to_game'] ? '<span class="green">В игре <i class="icon-info-sign right" rel="popover" data-content="' . $row['moved_to_game_date'] . '" data-original-title="Когда перенес в игру"></i></span>' : 'На складе') ?></td>
                <td><?php echo number_format($row['count'], 0, '', '.') ?></td>
                <td><?php echo number_format($row['price'], 0, '', '.') ?></td>
                <td>
                    <div class="btn-toolbar" style="margin: 0;">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="/backend/users/del_warehouse_item/<?php echo (int) get_segment_uri(4) ?>/<?php echo $row['id'] ?>/" class="delete"><i class="icon-trash"></i> Удалить</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="4"><?php echo lang('На складе пусто') ?></td>
        </tr>
    <?php } ?>
</table>

<?php echo $pagination ?>