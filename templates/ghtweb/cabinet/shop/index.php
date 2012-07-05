<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Личный кабинет'), 'url' => 'cabinet'),
        array('name' => lang('Магазин'), 'current' => true),
    ),
)) ?>

 
<div class="basket-block-info">
    <?php echo lang('Ваш баланс') ?> <span class="badge badge-info"><?php echo $this->auth->get('money') ?></span> <?php echo $this->config->item('shop_money_name') ?> (<?php echo anchor('payment_systems', lang('Пополнить баланс')) ?>)
</div>

<?php if($content) { ?>
    
    <?php if($this->session->flashdata('message')) { ?>
        <?php echo $this->session->flashdata('message') ?>
    <?php } ?>
    
    <?php echo form_open('cabinet/shop/buy') ?>
    
        <?php foreach($content as $category => $data) { ?>
            
            <h3 style="margin: 0 0 5px 0;"><?php echo $category ?></h3>
            
            <table class="table table-striped table-bordered">
                <tr>
                    <th width="8%"></th>
                    <th width="62%"><?php echo lang('Название') ?></th>
                    <th width="13%"><?php echo lang('Цена') ?> (<?php echo $this->config->item('shop_money_name') ?>)</th>
                    <th width="13%"><?php echo lang('Кол-во') ?></th>
                    <th width="4%"></th>
                </tr>
                <?php foreach($data as $i => $row) { ?>
                    <tr>
                        <td><img src="<?php echo (file_exists(FCPATH . 'resources/images/items/' . $row['item_id'] . '.gif') ? '/resources/images/items/' . $row['item_id'] . '.gif' : '/resources/images/items/blank.gif') ?>" alt="" title="<?php echo $row['name'] ?>" /></td>
                        <td>
                            <?php echo $row['name'] ?>
                            <i data-original-title="<?php echo lang('Информация о товаре') ?>" data-content="<?php echo lang('Дата окончания продаж') ?>: <i><?php echo $row['date_stop'] ?></i><br /><?php echo lang('Описание товара') ?>: <i><?php echo ($row['description'] == '' ? lang('Описания нет') : $row['description']) ?></i>" rel="popover" class="icon-info-sign right"></i>
                        </td>
                        <td><?php echo number_format($row['price'], 0, '', '.') ?></td>
                        <td><?php echo number_format($row['count'], 0, '', '.') ?></td>
                        <td>
                            <input type="checkbox" <?php echo ($this->auth->get('money') < 1 ? 'disabled' : '') ?> name="items[]" value="<?php echo $row['id'] ?>" class="basket-checkbox" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
            
        <?php } ?>

        <button type="submit" name="submit" class="btn btn-primary right" <?php echo ($this->auth->get('money') < 1 ? 'disabled' : '') ?>><?php echo lang('Купить выбранные товар(ы)') ?></button>

    <?php echo form_close() ?>
    
<?php } else { ?>
    <?php echo Message::info('Товаров нет') ?>
<?php } ?>