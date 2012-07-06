<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Личный кабинет'), 'url' => 'cabinet'),
        array('name' => lang('Игровые аккаунты'), 'current' => true),
    ),
)) ?>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<?php if(!$this->session->flashdata('message') && $message != '') { ?>
    <?php echo $message ?>
<?php } ?>

<?php if($game_accounts_list) { ?>
    
    <?php foreach($game_accounts_list as $sid => $row) { ?>
        
        <div class="page-header">
            <h1><?php echo lang('Сервер') ?>: <?php echo $row['name'] ?></h1>
        </div>
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="6%">#</th>
                    <th width="59%"><?php echo lang('Логин') ?></th>
                    <th width="30%"><?php echo lang('Последний вход в игру') ?></th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody>
                <?php if($row['accounts']) { ?>
                    <?php foreach($row['accounts'] as $key => $val) { ?>
                        <tr>
                            <td><?php echo ++$key ?></td>
                            <td><?php echo anchor('cabinet/game_accounts/view_account/' . $sid . '/' . $val['login'], $val['login']) ?></td>
                            <td><?php echo ($val['last_active'] > 0 ? date('Y-m-d H:i:s', substr($val['last_active'], 0, 10)) : 'n/a') ?></td>
                            <td>
                                <div class="btn-toolbar" style="margin: 0;">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><?php echo anchor('cabinet/game_accounts/view_account/' . $sid . '/' . $val['login'], '<i class="icon-user"></i> ' . lang('Персонажи')) ?></li>
                                            <li><?php echo anchor('cabinet/game_accounts/change_password/' . $val['login'] . '/' . $sid, '<i class="icon-lock"></i> ' . lang('Изменить пароль от аккаунта')) ?></li>
                                        </ul>
                                    </div><!-- /btn-group -->
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } elseif(isset($row['error'])) { ?>
                    <tr>
                        <td colspan="4"><?php echo $row['error'] ?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="4"><?php echo lang('Аккаунтов нет') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
    <?php } ?>

<?php }