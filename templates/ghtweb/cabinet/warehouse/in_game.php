<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Личный кабинет'), 'url' => 'cabinet'),
        array('name' => lang('Склад'), 'url' => 'cabinet/warehouse'),
        array('name' => lang('Передача предмета в игру'), 'current' => true),
    ),
)) ?>


<?php echo $message ?>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<?php if($game_accounts_list) { ?>
    
    <?php echo Message::info('Персонаж должен быть OFFLINE') ?>
    
    <?php echo Message::info('Передача предмета: :item_name в кол-ве: :item_count на сервер', array(
        ':item_name'  => '<b>' . $item_info['name'] . '</b>',
        ':item_count' => '<b>' . $item_info['count'] . '</b>',
    )) ?>
    
    <h3><?php echo lang('Выберите персонажа') ?></h3><br />
    
    <?php echo form_open('cabinet/warehouse/in_game_submit') ?>
        
        <input type="hidden" name="item_id" value="<?php echo $item_info['id'] ?>" />
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="6%">#</th>
                    <th width="79%"><?php echo lang('Имя') ?></th>
                    <th width="10%"><?php echo lang('Статус') ?></th>
                    <th width="5%"></th>
                </tr>
            </thead>
        
            <?php foreach($game_accounts_list as $sid => $row) { ?>
                <tbody>
                
                    <tr>
                        <th colspan="4"><?php echo lang('Сервер') ?>: <font color="BF8F00"><?php echo $row['name'] ?></font></th>
                    </tr>
                
                
                    <?php if($row['accounts']) { ?>
                        <?php foreach($row['accounts'] as $account_name => $accounts) { ?>
                            <tr>
                                <th colspan="4"><?php echo lang('Аккаунт') ?>: <font color="2D62FF"><?php echo $account_name ?></font></th>
                            </tr>
                            <?php foreach($accounts as $i => $account) { ?>
                                <tr>
                                    <td><?php echo ++$i ?></td>
                                    <td><?php echo $account['char_name'] ?></td>
                                    <td><?php echo ($account['online'] ? '<span class="green">online</span>' : '<span class="red">offline</span>') ?></td>
                                    <td>
                                        <input type="radio" <?php echo ($account['online'] ? 'disabled' : '') ?> name="char_id" value="<?php echo $sid . '|' . $account[$row['char_id']] ?>" />
                                    </td>
                                </tr>
                            <?php } ?>
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
                
            <?php } ?>

        </table>
        
        <input type="submit" value="<?php echo lang('На сервер') ?>" name="submit" class="btn right" />
        
    <?php echo form_close() ?>
    
    <div class="clear"></div>
    
<?php } else { ?>
    <?php echo Message::info('Данных нет') ?>
<?php } ?>