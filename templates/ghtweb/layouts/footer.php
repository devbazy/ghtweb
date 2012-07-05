			</div><!-- #content-->
		</div><!-- #container-->

		<div class="sidebar" id="sideRight">
			
            <!-- НАВИГАЦИЯ -->
            <h3><?php echo lang('Навигация') ?></h3>
            <ul class="sidebar-right-menu unstyled">
                <li><?php echo anchor('', lang('Главная')) ?></li>
                <li><?php echo anchor('news', lang('Новости')) ?></li>
                <li><?php echo anchor('register', lang('Регистрация')) ?></li>
                <li><?php echo anchor('login', lang('Личный кабинет')) ?></a></li>
                <li><?php echo anchor('stats', lang('Статистика')) ?></a></li>
                <li><?php echo anchor('payment_systems', lang('Пополнить баланс')) ?></a></li>
            </ul>
            
            <h3><?php echo lang('Статус сервера') ?></h3>
            <?php echo Server_status::get() ?>
            
            <h3><?php echo lang('Темы с форума') ?></h3>
            <?php echo Forum_threads::get() ?>
            
            <h3><?php echo lang('ТОП ПВП') ?></h3>
            <?php echo Top_pvp::get() ?>
            
            <h3><?php echo lang('ТОП ПК') ?></h3>
            <?php echo Top_pk::get() ?>
            
		</div><!-- .sidebar#sideRight -->

	</div><!-- #middle-->

</div><!-- #wrapper -->

<div class="clear"></div>

<br />

<div id="footer">
	<a href="http://ghtweb.ru/" target="_blank">ghtweb</a>
</div><!-- #footer -->
</body>
</html>