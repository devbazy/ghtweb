<?php echo lang('Здравствуйте!<br /><br />
Вы успешно зарегистрировались на :base_url <br /><br />
Ваши регистрационные данные: <br />
Login: :login <br />
Password: тот что указали при регистрации <br /><br />
С уважение Администрация :base_url', array(
    ':base_url' => base_url(get_lang()),
    ':login'    => $login,
)) ?>
