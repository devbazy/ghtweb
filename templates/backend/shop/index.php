<div class="page-header">
    <h1>Магазин <small>список товаров</small> <span class="badge badge-info"><?php echo $count ?></span></h1>
</div>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<table class="table table-striped table-bordered">
    <tr>
        <th width="5%"></th>
    	<th width="39%">Название</th>
    	<th width="7%">Кол-во</th>
    	<th width="7%">Продано</th>
    	<th width="30%">Даты старта / окончания продаж</th>
    	<th width="8%">Статус</th>
    	<th width="4%"></th>
    </tr>
    <?php if($content) { ?>
        <?php foreach($content as $row) { ?>
            <tr>
                <td><img src="<?php echo (file_exists(FCPATH . 'resources/images/items/' . $row['item_id'] . '.gif') ? '/resources/images/items/' . $row['item_id'] . '.gif' : '/resources/images/items/blank.gif') ?>" alt="" title="<?php echo $row['name'] ?>" /></td>
            	<td><?php echo $row['name'] ?> (<?php echo $row['item_id'] ?>) <?php echo ($row['grade'] != 'none' ? '<img src="/resources/images/grade/grade_' . $row['grade'] . '.gif" style="margin: 0 0 0 5px;" />' : '') ?> &nbsp;<i data-original-title="Описание" data-content="<?php echo ($row['description'] == '' ? lang('Описания нет') : $row['description']) ?>" rel="popover" class="icon-info-sign right"></i></td>
            	<td><?php echo $row['count'] ?></td>
            	<td><?php echo $row['count_sold'] ?></td>
            	<td><?php echo ($row['date_start'] == '0000-00-00 00:00:00' ? 'не установлена' : '<span class="label">' . $row['date_start']) ?></span> / <?php echo ($row['date_stop'] == '0000-00-00 00:00:00' ? 'не установлена' : (db_date() > $row['date_stop'] ? '<span class="label label-important">' . $row['date_stop'] . '</span>' : '<span class="label label-success">' . $row['date_stop'] . '</span>')) ?></td>
            	<td><?php echo ($row['allow'] ? '<span class="label label-success">Вкл</span>' : '<span class="label label-important">Выкл</span>') ?></td>
            	<td>
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu" style="z-index: 999;">
<!--                                <li><a href="/backend/shop/edit/--><?php //echo $row['id'] ?><!--/"><i class="icon-pencil"></i> Редактировать</a></li>-->
                                <li><a href="/backend/shop/stop/<?php echo $row['id'] ?>/<?php echo ($row['allow'] ? 'off' : 'on') ?>/"><?php echo ($row['allow'] ? '<i class="icon-remove-sign"></i> Отключить' : '<i class="icon-ok-sign"></i> Включить') ?></a></li>
                                <li><a href="/backend/shop/del/<?php echo $row['id'] ?>/" class="delete"><i class="icon-trash"></i> Удалить</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="7">Товаров нет</td>
        </tr>
    <?php } ?>
</table>

<?php echo $pagination ?>