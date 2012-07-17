<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Личный кабинет'), 'url' => 'cabinet'),
        array('name' => lang('Склад'), 'current' => true),
    ),
)) ?>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<!-- Подарки -->
<?php if($gifts) { ?>
    
    <h2><?php echo lang('Подарки') ?> <span class="badge badge-info"><?php echo count($gifts) ?></span></h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th width="8%"></th>
            <th width="40%"><?php echo lang('Название') ?></th>
            <th width="20%"><?php echo lang('От кого') ?></th>
            <th width="13%"><?php echo lang('Заточка') ?></th>
            <th width="13%"><?php echo lang('Кол-во') ?></th>
            <th width="6%"></th>
        </tr>
        <?php foreach($gifts as $gift) { ?>
            <tr>
                <td><img src="<?php echo (file_exists(FCPATH . 'resources/images/items/' . $gift['item_id'] . '.gif') ? '/resources/images/items/' . $gift['item_id'] . '.gif' : '/resources/images/items/blank.gif') ?>" alt="" title="<?php echo $gift['name'] ?>" /></td>
                <td><?php echo $gift['name'] ?> <?php echo ($gift['grade'] != 'none' ? '<img src="/resources/images/grade/grade_' . $gift['grade'] . '.gif" style="margin: 0 0 0 5px;" />' : '') ?></td>
                <td><?php echo $gift['login'] ?></td>
                <td><font color="<?php echo definition_enchant_color($gift['enchant_level']) ?>"><?php echo $gift['enchant_level'] ?></font></td>
                <td><?php echo number_format($gift['count'], 0, '', '.') ?></td>
                <td>
                    <div class="btn-toolbar" style="margin: 0;">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><?php echo anchor('cabinet/warehouse/gift_action/' . $gift['id'] . '/accept/', '<i class="icon-ok"></i> ' . lang('Принять подарок')) ?></li>
                                <li><?php echo anchor('cabinet/warehouse/gift_action/' . $gift['id'] . '/del/', '<i class="icon-trash"></i> ' . lang('Удалить подарок')) ?></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>


<h2><?php echo lang('Товары на складе') ?> <span class="badge badge-info"><?php echo $count ?></span></h2>
<table class="table table-striped table-bordered">
    <tr>
        <th width="8%"></th>
        <th width="60%"><?php echo lang('Название') ?></th>
        <th width="13%"><?php echo lang('Кол-во') ?></th>
        <th width="13%"><?php echo lang('Заточка') ?></th>
        <th width="6%"></th>
    </tr>
    <?php if($content) { ?>
        <?php foreach($content as $row) { ?>
            <tr>
                <td><img src="<?php echo (file_exists(FCPATH . 'resources/images/items/' . $row['item_id'] . '.gif') ? '/resources/images/items/' . $row['item_id'] . '.gif' : '/resources/images/items/blank.gif') ?>" alt="" title="<?php echo $row['item_name'] ?>" /></td>
                <td><?php echo $row['item_name'] ?> <?php echo ($row['grade'] != 'none' ? '<img src="/resources/images/grade/grade_' . $row['grade'] . '.gif" style="margin: 0 0 0 5px;" />' : '') ?></td>
                <td><?php echo number_format($row['count'], 0, '', '.') ?></td>
                <td><font color="<?php echo definition_enchant_color($row['enchant_level']) ?>"><?php echo $row['enchant_level'] ?></font></td>
                <td>
                    <div class="btn-toolbar" style="margin: 0;">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a class="gift_friend" item-id="<?php echo $row['id'] ?>" item-name="<?php echo $row['item_name'] ?>"><i class="icon-gift"></i> <?php echo lang('Подарить другу') ?></a></li>
                                <li><?php echo anchor('cabinet/warehouse/in_game/' . $row['id'], '<i class="icon-briefcase"></i> ' . lang('На склад в игру')) ?></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="5"><?php echo lang('На складе пусто') ?></td>
        </tr>
    <?php } ?>
</table>

<?php echo $pagination ?>

<!-- MODAL BOX -->
<div class="modal" id="modal-box-gift-friend" style="display: none">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3><?php echo lang('Подарок другу') ?> <span></span></h3>
    </div>
    <?php echo form_open('', 'class="form-horizontal modal-box-gift-friend"') ?>
        <input type="hidden" name="item_id" value="" />
        <div class="modal-body">
            <h3 class="item-name-block"></h3>
            <fieldset>
                <div class="control-group">
                    <label for="login" class="control-label"><?php echo lang('Логин друга') ?></label>
                    <div class="controls">
                        <input type="text" name="login" id="login" value="<?php echo set_value('login') ?>" class="input-xlarge" placeholder="<?php echo lang('Введите Логин от личного кабинета друга') ?>" />
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" style="margin: 0 0 0 165px;" type="submit" name="submit" data-text="<?php echo lang('Загрузка...') ?>"><?php echo lang('Подарить') ?></button>
            <a class="btn close-button"><?php echo lang('Закрыть') ?></a>
        </div>
    <?php echo form_close() ?>
</div>