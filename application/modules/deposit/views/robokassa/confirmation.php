<?php echo form_open($form_url) ?>
    <table class="table">
        <tr>
            <td><?php echo lang('Метод оплаты') ?></td>
            <td>ROBOKASSA</td>
        </tr>
        <tr>
            <td width="30%"><?php echo lang('Номер заявки') ?></td>
            <td width="70%">#<?php echo $id ?></td>
        </tr>
        <tr>
            <td><?php echo lang('Отдаёте') ?></td>
            <td><?php echo $sum ?> <?php echo lang('руб.') ?></td>
        </tr>
        <tr>
            <td><?php echo lang('Получаете') ?></td>
            <td><?php echo $count_item ?> <?php echo $this->config->item('shop_money_name') ?></td>
        </tr>
    </table>
    <button type="submit" name="submit" class="btn btn-primary"><?php echo lang('Перейти к оплате') ?></button>
    <?php echo anchor('payment_systems/back', lang('Назад'), 'class="btn"') ?>
    <?php echo $inputs ?>
<?php echo form_close() ?>