<?php echo form_open('', 'class="form-horizontal"') ?>
            
    <?php echo Message::info('Стоймость 1 :item_name - :sum рублей <br /><b>Сумма при оплате может незначительно отличаться из-за разницы в курсах</b>', array(
        ':item_name' => '<b>' . $this->config->item('shop_money_name') . '</b>',
        ':sum'       => '<b>' . $this->config->item('shop_items_sum') . '</b>',
    )) ?>

    <script type="text/javascript">
    $(function(){
        get_sum();
        $('#count').bind('keyup',get_sum);
    })
    
    function get_sum()
    {
        var self  = $('#count');
        var count = parseInt(self.val()) || 0;

        $('p.help-block:last b').html(count * <?php echo $this->config->item('shop_items_sum') ?>);
    }
    </script>

    <fieldset>
        <div class="control-group<?php echo (form_error('login') ? ' error' : '') ?>">
            <label for="login" class="control-label"><?php echo lang('Логин') ?></label>
            <div class="controls">
                <input type="text" name="login" id="login" value="<?php echo set_value('login', ($this->auth->get('login') ? $this->auth->get('login') : '')) ?>" class="input-xlarge" placeholder="<?php echo lang('Введите логин от личного кабинета') ?>" />
                <p class="help-block"><?php echo lang('Введите логин от личного кабинета куда будут зачислены :item_name', array(':item_name' => $this->config->item('shop_money_name'))) ?></p>
                <?php if(form_error('login')) { ?>
                    <p class="help-block"><?php echo form_error('login') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="control-group<?php echo (form_error('count') ? ' error' : '') ?>">
            <label for="count" class="control-label"><?php echo lang('Количество') ?></label>
            <div class="controls">
                <input type="text" name="count" id="count" value="<?php echo set_value('count', 0) ?>" class="input-xlarge" placeholder="<?php echo lang('Введите сколько :item_name хотите получить', array(':item_name' => $this->config->item('shop_money_name'))) ?>" />
                <p class="help-block"><?php echo lang('Вы отдаёте: :count руб.', array(':count' => '<b>0</b>')) ?></p>
                <?php if(form_error('count')) { ?>
                    <p class="help-block"><?php echo form_error('count') ?></p>
                <?php } ?>
            </div>
        </div>
        <button class="btn btn-primary" style="margin: 0 0 0 165px;" type="submit" name="submit"><?php echo lang('Далее') ?></button>
    </fieldset>    

<?php echo form_close() ?>