<?php echo lang('Вы запросили новый пароль на сайте :base_url<br /><br />
Для восстановления пароля пройдите по ссылке:<br />
:forgotten_link<br /><br />
С Уважением администрация :base_url', array(
    ':base_url'       => base_url(get_lang()),
    ':forgotten_link' => $forgotten_link,
)) ?>
