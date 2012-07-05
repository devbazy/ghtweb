<?php echo breadcrumb(array(
    'links' => array(
        array('name' => lang('Главная'), 'url' => ''),
        array('name' => lang('Пополнение баланса'), 'current' => true),
    ),
)) ?>

<?php if(!$this->config->item('robokassa_allow')) { ?>
    <?php echo Message::info('Модуль отключен') ?>
<?php } elseif($this->auth->get('is_logged')) { ?>

    <script type="text/javascript">
    $(function(){

        $('#count').val('');
        
        var mc = '<?php echo $this->config->item('shop_items_sum') ?>';
        
        $('#count').bind('keyup', function(){
            var self = $(this),
                val  = self.val();
            
            if($.isNumeric(val))
            {
                $('p.help-block:first b').html(val * mc);
            }
            else
            {
                $('#count').val('');
                $('p.help-block:first b').html(0);
            }
        });

    })
    </script>

    <?php echo $message ?>

    <?php if($step == 1) { ?>

        <?php echo form_open('', 'class="form-horizontal"') ?>
            
            <?php echo Message::info('Стоймость 1 :item_name - :sum рублей', array(
                ':item_name' => '<b>' . $this->config->item('shop_money_name') . '</b>',
                ':sum'       => '<b>' . $this->config->item('shop_items_sum') . '</b>',
            )) ?>
            
            <?php echo Message::false('Сумма при оплате может незначительно отличаться из-за разницы в курсах') ?>
            
            <div class="msg-box"></div>
            
            <fieldset>
                <div class="control-group<?php echo (form_error('count') ? ' error' : '') ?>">
                    <label for="count" class="control-label"><?php echo lang('Введите кол-во') ?></label>
                    <div class="controls">
                        <input type="text" name="count" id="count" value="<?php echo set_value('count') ?>" class="input-xlarge" placeholder="<?php echo lang('Введите Сколько :item_name хотите получить', array(':item_name' => $this->config->item('shop_money_name'))) ?>" />
                        <p class="help-block"><?php echo lang('Стоймость :') ?> <b>0</b> <?php echo lang('рублей') ?></p>
                        <?php if(form_error('count')) { ?>
                            <p class="help-block"><?php echo form_error('count') ?></p>
                        <?php } ?>
                    </div>
                </div>
                <button class="btn btn-primary" style="margin: 0 0 0 165px;" type="submit" name="submit"><?php echo lang('Далее') ?></button>
            </fieldset>    

        <?php echo form_close() ?>

    <?php } elseif($step == 2) { ?>
        
        <?php echo form_open($form_url) ?>
            <table class="table">
                <tr>
                    <td><?php echo lang('Метод оплаты') ?></td>
                    <td>ROBOKASSA</td>
                </tr>
                <tr>
                    <td width="30%"><?php echo lang('Номер заявки') ?></td>
                    <td width="70%">#<?php echo (isset($data_order['order_number']) ? $data_order['order_number'] : '') ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('Отдаёте') ?></td>
                    <td><?php echo (isset($data_order['sum']) ? $data_order['sum'] : '') ?> <?php echo lang('рублей') ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('Получаете') ?></td>
                    <td><?php echo (isset($data_order['count_item']) ? $data_order['count_item'] : '') ?> <?php echo $this->config->item('shop_money_name') ?></td>
                </tr>
            </table>
            <button type="submit" name="submit" class="btn btn-primary"><?php echo lang('Перейти к оплате') ?></button>
            <?php echo anchor('cabinet/deposit', lang('Назад'), 'class="btn"') ?>
            <?php echo (isset($data_order['form']) ? $data_order['form'] : '') ?>
        <?php echo form_close() ?>
        
    <?php } ?>    
<?php } else { ?>
    <?php echo Message::info('Для пополнения баланса надо <a href=":reg_link">зарегистрироваться</a> или <a href=":auth_link">авторизироваться</a>', array(
        ':reg_link'  => '/' . get_lang() . 'register/',
        ':auth_link' => '/' . get_lang() . 'login/',
    )) ?>
<?php } ?>