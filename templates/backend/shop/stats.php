<div class="page-header">
    <h1>Магазин <small>статистика</small> <span class="badge badge-info"><?php echo $count ?></span></h1>
</div>

<?php echo form_open('', 'class="form-horizontal" method="get" style="margin: 0;"') ?>
    <fieldset>
        <div class="control-group">
            <input type="text" name="item_id" value="<?php echo $this->input->get('item_id') ?>" placeholder="ID предмета" class="span2" />
            <input type="text" name="login" value="<?php echo $this->input->get('login') ?>" placeholder="Логин покупателя" class="span2" />
            <input type="text" name="price" value="<?php echo $this->input->get('price') ?>" placeholder="Цена" class="span2" />
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
        <th width="5%"></th>
    	<th width="43%">Название</th>
    	<th width="16%">Покупатель</th>
    	<th width="11%">Кол-во</th>
    	<th width="9%">Цена</th>
    	<th width="16%">Дата продажи</th>
    </tr>
    <?php if($content) { ?>
        <?php foreach($content as $row) { ?>
            <tr>
                <td><img src="<?php echo (file_exists(FCPATH . 'resources/images/items/' . $row['item_id'] . '.gif') ? '/resources/images/items/' . $row['item_id'] . '.gif' : '/resources/images/items/blank.gif') ?>" alt="" title="<?php echo $row['item_name'] ?>" /></td>
                <td><?php echo $row['item_name'] ?> (<?php echo $row['item_id'] ?>) <?php echo ($row['grade'] != 'none' ? '<img src="/resources/images/grade/grade_' . $row['grade'] . '.gif" style="margin: 0 0 0 5px;" />' : '') ?></td>
            	<td><a href="/backend/users/edit/<?php echo $row['user_id'] ?>" target="_blank" rel="tooltip" title="Перейти к просмотру пользователя"><?php echo $row['login'] ?></a></td>
            	<td><?php echo $row['count'] ?></td>
            	<td><?php echo $row['price'] ?></td>
            	<td><?php echo $row['date'] ?></td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="6">Продаж нет</td>
        </tr>
    <?php } ?>
</table>

<?php echo $pagination ?>