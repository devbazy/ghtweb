<?php echo lang('Для того чтобы активировать Ваш аккаунт пройдите по ссылке ниже<br />
<a href=":activation_link">:activation_link</a><br /><br />
С уважение Администрация :base_url', array(
    ':activation_link' => $activation_link,
    ':base_url'        => base_url(get_lang()),
)) ?>
