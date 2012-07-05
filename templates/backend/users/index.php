<div class="page-header">
    <h1>Пользователи сайта <small>список</small> <span class="badge badge-info"><?php echo $count ?></span></h1>
</div>

<?php echo form_open('', 'class="form-horizontal" method="get" style="margin: 0;"') ?>
    <fieldset>
        <div class="control-group">
            <input type="text" name="login" value="<?php echo $this->input->get('login') ?>" placeholder="Логин" class="span2" />
            <input type="text" name="email" value="<?php echo $this->input->get('email') ?>" placeholder="Email" class="span2" />
            <input type="text" name="last_ip" value="<?php echo $this->input->get('last_ip') ?>" placeholder="IP" class="span2" />
            <button class="btn btn-primary" type="submit">Искать</button>
            <a href="/<?php echo $this->uri->uri_string() ?>/" class="btn">Сброс</a>
        </div>
    </fieldset>
<?php echo form_close() ?>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<table class="table table-striped table-bordered">
    <tr>
        <th width="3%">#</th>
    	<th width="35%">Логин</th>
    	<th width="25%">Email</th>
    	<th width="12%">Статус</th>
    	<th width="6%">Бан</th>
    	<th width="15%">Дата регистрации</th>
    	<th width="4%"></th>
    </tr>
    <?php if($content) { ?>
        <?php $oO = (!empty($_GET['per_page']) ? (int) $_GET['per_page'] + 1 : 1); foreach($content as $row) { ?>
            <tr>
                <td><?php echo $oO ?></td>
            	<td><?php echo $row['login'] ?></td>
            	<td><?php echo $row['email'] ?></td>
            	<td><?php echo ($row['activated'] ? '<span class="label label-success">Активирован</span>' : '<span class="label label-important">Не активирован</span>') ?></td>
            	<td><?php echo ($row['banned'] ? '<span class="label label-important">Да</span> <i class="icon-info-sign" rel="popover" data-content="' . ($row['banned_reason'] != '' ? $row['banned_reason'] : 'Не указана') . '" data-original-title="Причина бана"></i>' : '<span class="label label-success">Нет</span>') ?></td>
            	<td><?php echo $row['joined'] ?></td>
            	<td>
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu" style="z-index: 999;">
                                <li><a href="/backend/users/edit/<?php echo $row['user_id'] ?>/"><i class="icon-pencil"></i> Редактировать</a></li>
                                <?php if(!$row['activated']) { ?>
                                    <li><a href="/backend/users/activated/<?php echo $row['user_id'] ?>/"><i class="icon-ok"></i> Активировать</a></li>
                                <?php } ?>
                                <li><a href="/backend/users/banned/<?php echo $row['user_id'] ?>/<?php echo ($row['banned'] ? 'off' : 'on') ?>/" class="users-ban" login="<?php echo $row['login'] ?>"><?php echo ($row['banned'] ? '<i class="icon-ok-circle"></i> Разбанить' : '<i class="icon-ban-circle"></i> Забанить') ?></a></li>
                                <li><a href="/backend/users/warehouse/<?php echo $row['user_id'] ?>/"><i class="icon-th"></i> Вещи на складе</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </td>
            </tr>
        <?php $oO++; } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="7">Пользователей сайта нет</td>
        </tr>
    <?php } ?>
</table>

<?php echo $pagination ?>


<!-- MODAL BOX -->
<div class="modal" id="modal-box-user-ban" style="display: none">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Бан пользователя <span></span></h3>
    </div>
    <?php echo form_open('', 'class="form-horizontal modal-box-user-ban"') ?>
        <div class="modal-body">
            <fieldset>
                <div class="control-group">
                    <label for="banned_reason" class="control-label">Причина бана</label>
                    <div class="controls">
                        <textarea name="banned_reason" id="" cols="30" rows="6" class="span4" placeholder="Введите причину бана"></textarea>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" style="margin: 0 0 0 165px;" type="submit" name="submit" data-text="Загрузка...">Забанить</button>
            <a class="btn close-button">Закрыть</a>
        </div>
    <?php echo form_close() ?>
</div>