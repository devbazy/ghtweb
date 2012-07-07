<div class="page-header">
    <h1>Аккаунты <small>просмотр</small> <span class="badge badge-info"><?php echo $count ?></span></h1>
    <div class="right" style="margin: -15px 0 0;">
        <?php if($server_list) { ?>
            <?php foreach($server_list as $server_id => $server_name) { ?>
                <a <?php echo $this->_data['server_id'] == $server_id ? '' : ('href="/backend/accounts/' . $server_id . '/"') ?> class="btn btn-info btn-mini <?php echo ($this->_data['server_id'] == $server_id ? 'disabled' : '') ?>"><?php echo $server_name ?></a>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<?php echo form_open('', 'class="form-horizontal" method="get" style="margin: 0;"') ?>
    <fieldset>
        <div class="control-group">
            <input type="text" name="login" value="<?php echo $this->input->get('login') ?>" placeholder="Логин" />
            <button class="btn btn-primary" type="submit">Искать</button>
            <a href="/<?php echo $this->uri->uri_string() ?>/" class="btn">Сброс</a>
        </div>
    </fieldset>
<?php echo form_close() ?>

<?php echo $message ?>

<table class="table table-striped table-bordered">
    <tr>
        <th width="3%">#</th>
        <th width="50%">Логин</th>
        <th width="43%">Последний визит</th>
        <th width="4%"></th>
    </tr>
    <?php if($content) { ?>
        <?php $oO = (!empty($_GET['per_page']) ? (int) $_GET['per_page'] + 1 : 1); foreach($content as $row) { ?>
            <tr>
                <td><?php echo $oO ?></td>
            	<td><?php echo $row['login'] ?></td>
                <td><?php echo lastactive($row['last_active']) ?></td>
                <td>
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu" style="z-index: 999;">
                                <li><a href="/backend/characters/<?php echo $this->_data['server_id'] ?>/characters_in_account/<?php echo $row['login'] ?>/"><i class="icon-user"></i> Персонажи</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </td>
            </tr>
        <?php $oO++; } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="4">Аккаунты не найдены</td>
        </tr>
    <?php } ?>

</table>

<?php echo $pagination ?>
