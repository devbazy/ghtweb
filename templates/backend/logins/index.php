<div class="page-header">
    <h1>Логин сервера <small>список</small> <span class="badge badge-info"><?php echo $count ?></span></h1>
</div>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<table class="table table-striped table-bordered">
    <tr>
        <th width="3%">#</th>
    	<th width="58%">Название</th>
    	<th width="15%">ip:port</th>
    	<th width="8%">Статус</th>
    	<th width="10%">Версия</th>
    	<th width="6%"></th>
    </tr>
    <?php if($content) { ?>
        <?php $oO = (!empty($_GET['per_page']) ? (int) $_GET['per_page'] + 1 : 1); foreach($content as $row) { ?>
            <tr>
                <td><?php echo $oO ?></td>
            	<td><?php echo $row['name'] ?></td>
            	<td><?php echo $row['ip'] ?>:<?php echo $row['port'] ?></td>
            	<td><?php echo ($row['allow'] ? '<span class="label label-success">Вкл</span>' : '<span class="label label-important">Выкл</span>') ?></td>
            	<td><?php echo $row['version'] ?></td>
            	<td>
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu" style="z-index: 999;">
                                <li><a href="/backend/logins/edit/<?php echo $row['id'] ?>/"><i class="icon-pencil"></i> Редактировать</a></li>
                                <li><a href="/backend/logins/stop/<?php echo $row['id'] ?>/<?php echo ($row['allow'] ? 'off' : 'on') ?>/"><?php echo ($row['allow'] ? '<i class="icon-remove-sign"></i> Отключить' : '<i class="icon-ok-sign"></i> Включить') ?></a></li>
                                <li><a href="/backend/logins/del/<?php echo $row['id'] ?>/" class="delete"><i class="icon-trash"></i> Удалить</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </td>
            </tr>
        <?php $oO++; } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="6">Логинов нет</td>
        </tr>
    <?php } ?>
</table>

<?php echo $pagination ?>