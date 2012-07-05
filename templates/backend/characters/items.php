<div class="page-header">
    <h1>Персонажи <small>предметы на персонаже</small>
        <span class="badge badge-info"><?php echo $char_data['char_name'] ?></span>
        <small>сервер</small>
        <span class="badge badge-info"><?php echo $this->_data['server_list'][$server_id] ?></span>
    </h1>
</div>

<table class="table table-striped table-bordered">
    <tr>
        <td width="20%"><b>account_name:</b> <?php echo $char_data['account_name'] ?> <a href="/backend/characters/<?php echo $server_id ?>/characters_in_account/<?php echo $char_data['account_name'] ?>/" rel="tooltip" title="Все персонажи на этом аккаунте">ещё</a></td>
        <td width="20%"><b>char_name:</b> <?php echo $char_data['char_name'] ?></td>
        <td width="20%"><b>level:</b> <?php echo $char_data['level'] ?></td>
        <td width="20%"><b>curHp:</b> <?php echo reset(explode('.', $char_data['curHp'])) ?></td>
        <td width="20%"><b>curMp:</b> <?php echo reset(explode('.', $char_data['curMp'])) ?></td>
    </tr>
    <tr>
    	<td><b>sex:</b> <img src="/resources/images/sex/<?php echo $char_data['sex'] ?>.png" alt="" rel="tooltip" title="<?php echo ($char_data['sex'] ? 'female' : 'male') ?>" /></td>
    	<td><b>karma:</b> <?php echo $char_data['karma'] ?></td>
    	<td><b>pvpkills:</b> <?php echo $char_data['pvpkills'] ?></td>
    	<td><b>pkkills:</b> <?php echo $char_data['pkkills'] ?></td>
    	<td><b>classid:</b> <?php echo get_class_name_by_id($char_data['classid']) ?></td>
    </tr>
    <tr>
    	<td><b>title:</b> <?php echo ($char_data['title'] == '' ? 'нет' : $char_data['title']) ?></td>
    	<td><b>online:</b> <?php echo ($char_data['online'] ? '<span class="green">online</span>' : '<span class="red">offline</span>') ?></td>
    	<td><b>onlinetime:</b> <?php echo online_time($char_data['onlinetime']) ?></td>
    	<td><b>clan:</b> <?php echo ($char_data['clan_name'] == '' ? 'n/a' : $char_data['clan_name']) ?></td>
    	<td></td>
    </tr>
</table>

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
    
    $('#form-del-item').submit(function(){
        if(confirm('Точно удалить?'))
        {
            return true;
        }
        return false;
    });
})
</script>

<?php echo form_open('backend/characters/add_item', 'class="form-horizontal" style="margin: 0; width: 670px; float: left;"') ?>
    <fieldset>
        <span class="red">*</span> Начните вводить <b>название</b>, если в базе найдутся совпадения то список предметов появиться
        <div class="control-group">
            <input type="hidden" name="item_id" />
            <input type="hidden" name="char_id" value="<?php echo (int) get_segment_uri(5) ?>" />
            <input type="hidden" name="server_id" value="<?php echo $server_id ?>" />
            <input type="text" name="item_name" id="item_name" class="" placeholder="Название" />
            <input type="text" name="count" class="span2" placeholder="Кол-во" />
            <input type="text" name="enchant" class="span2" placeholder="Заточка" />
            <input type="checkbox" name="type" value="insert" rel="tooltip" title="Не складывается в кучу, а добавляется отдельно" />
            <button class="btn btn-primary" type="submit" name="submit">Добавить предмет</button>
        </div>
    </fieldset>
<?php echo form_close() ?>

<?php if($content) { ?>
    <?php echo form_open('backend/characters/del_items', 'class="form-horizontal" id="form-del-item" style="margin: 0; width: 190px; float: left; padding-top: 17px;"') ?>
        <fieldset>
            <div class="control-group">
                <input type="hidden" name="char_id" value="<?php echo (int) get_segment_uri(5) ?>" />
                <input type="hidden" name="server_id" value="<?php echo $server_id ?>" />
                <button class="btn btn-danger" type="submit" name="delsubmit">Удалить все предметы</button>
            </div>
        </fieldset>
    <?php echo form_close() ?>
<?php } ?>

<?php echo $message ?>

<table class="table table-striped table-bordered">
    <tr>
        <th width="3%"></th>
        <th width="63%">Название</th>
        <th width="10%">Кол-во</th>
        <th width="10%">Находится</th>
        <th width="10%">Заточка</th>
        <th width="4%"></th>
    </tr>
    <?php if($content) { ?>
        <?php foreach($content as $row) { ?>
            <tr>
                <td><img src="<?php echo (file_exists(FCPATH . 'resources/images/items/' . $row['item_id'] . '.gif') ? '/resources/images/items/' . $row['item_id'] . '.gif' : '/resources/images/items/blank.gif') ?>" alt="" title="<?php echo $row['item_name'] ?>" /></td>
            	<td><?php echo $row['item_name'] ?> (<?php echo $row['item_id'] ?>)</td>
                <td><?php echo number_format($row['count'], 0, '', '.') ?></td>
            	<td><?php echo $row['loc'] ?></td>
            	<td><?php echo ($row['enchant_level'] > 0 ? '<font color="' . definition_enchant_color($row['enchant_level']) . '">' . $row['enchant_level'] . '</font>' : $row['enchant_level']) ?></td>
                <td>
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu" style="z-index: 999;">
                                <li><a href="/backend/characters/<?php echo $server_id ?>/del_item/<?php echo $row['object_id'] ?>/char_id/<?php echo $char_data[$char_id] ?>/"><i class="icon-trash"></i> Удалить</a></li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="6">Предметы не найдены</td>
        </tr>
    <?php } ?>

</table>

<?php echo $pagination ?>