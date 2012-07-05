<div class="page-header">
    <h1>Страницы <small>список</small> <span class="badge badge-info"><?php echo $count ?></span></h1>
</div>

<?php echo form_open('', 'class="form-horizontal" method="get" style="margin: 0;"') ?>
    <fieldset>
        <div class="control-group">
            <input type="text" name="title" value="<?php echo $this->input->get('title') ?>" placeholder="Название" class="span2" />
            <input type="text" name="page" value="<?php echo $this->input->get('page') ?>" placeholder="Ссылка" class="span2" />
            <?php echo form_dropdown('lang', $this->config->item('languages'), $this->input->get('lang'), 'class="span2"') ?>
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
        <th width="4%">#</th>
    	<th width="46%">Название</th>
    	<th width="15%">Ссылка</th>
    	<th width="8%">Статус</th>
    	<th width="8%">Язык</th>
    	<th width="15%">Дата создания</th>
    	<th width="4%"></th>
    </tr>
    <?php if($content) { ?>
        <?php $oO = (!empty($_GET['per_page']) ? (int) $_GET['per_page'] + 1 : 1); foreach($content as $row) { ?>
            <tr>
                <td><?php echo $oO ?></td>
            	<td><?php echo $row['title'] ?></td>
            	<td><a href="/<?php echo $row['lang'] ?>/page/<?php echo $row['page'] ?>/" target="_blank"><?php echo $row['page'] ?></a></td>
            	<td><?php echo ($row['allow'] ? '<span class="label label-success">Вкл</span>' : '<span class="label label-important">Выкл</span>') ?></td>
            	<td><?php echo $row['lang'] ?></td>
            	<td><?php echo $row['date'] ?></td>
            	<td>
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu" style="z-index: 999;">
                                <li><a href="/backend/pages/edit/<?php echo $row['id'] ?>/"><i class="icon-pencil"></i> Редактировать</a></li>
                                <li><a href="/backend/pages/stop/<?php echo $row['id'] ?>/<?php echo ($row['allow'] ? 'off' : 'on') ?>/"><?php echo ($row['allow'] ? '<i class="icon-remove-sign"></i> Отключить' : '<i class="icon-ok-sign"></i> Включить') ?></a></li>
                                <li><a href="/backend/pages/del/<?php echo $row['id'] ?>/" class="delete"><i class="icon-trash"></i> Удалить</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </td>
            </tr>
        <?php $oO++; } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="6">Страниц нет</td>
        </tr>
    <?php } ?>
</table>

<?php echo $pagination ?>