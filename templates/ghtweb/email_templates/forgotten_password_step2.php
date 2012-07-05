<?php echo lang('Вы запрашивали восстановление пароля на сайте :base_url<br /><br />
Ваш новый пароль:<br />:password<br /><br />
С Уважением администрация :base_url', array(
    ':base_url' => base_url(get_lang()),
    ':password' => $password,
)) ?>
